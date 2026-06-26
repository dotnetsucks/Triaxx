using System;
using System.Collections.Specialized;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Net.Http;
using System.Runtime.CompilerServices;
using System.Text.Json;
using System.Threading.Tasks;
using System.Web;
using DiscordRPC;
using DiscordRPC.Logging;

internal class Program
{
    private const string ver = "bootaxx-nfoNAOFIOWjfIAFioiwfJIWAjfoawIFJAOfoIOAFWIjfoiIFIOfwa";
    private const string compar = "https://triaxx.nl/BootstrapperVersion.php";
    private const string DiscordAppId = "1515607739034763274";

    private static bool checkDisc()
    {
        return Process.GetProcessesByName("Discord").Any() ||
               Process.GetProcessesByName("DiscordCanary").Any() ||
               Process.GetProcessesByName("DiscordPTB").Any();
    }

    private static async Task Main(string[] args)
    {
        try
        {
            using (HttpClient versionClient = new HttpClient())
            {
                string text = (await versionClient.GetStringAsync("https://triaxx.nl/BootstrapperVersion.php")).Trim();
                if (!string.Equals("bootaxx-nfoNAOFIOWjfIAFioiwfJIWAjfoawIFJAOfoIOAFWIjfoiIFIOfwa", text, StringComparison.Ordinal))
                {
                    Console.WriteLine("Your version of Triaxx is outdated, please update to the latest version.");
                    Console.ReadKey();
                    return;
                }
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine("version check failed: " + ex.Message);
            Console.ReadKey();
            return;
        }

        string key = null;
        int gid = 0;
        Uri uri;
        if (args.Length == 1 && args[0].StartsWith("triaxx://", StringComparison.OrdinalIgnoreCase) && Uri.TryCreate(args[0], UriKind.Absolute, out uri))
        {
            NameValueCollection nameValueCollection = HttpUtility.ParseQueryString(uri.Query);
            key = nameValueCollection["key"];
            int.TryParse(nameValueCollection["gid"], out gid);
        }

        if (string.IsNullOrWhiteSpace(key))
        {
            Console.WriteLine("missing key");
            Console.ReadKey();
        }
        else
        {
            DiscordRpcClient discord = null;
            try
            {
                using (HttpClient versionClient = new HttpClient())
                {
                    HttpResponseMessage httpResponseMessage = await versionClient.GetAsync("http://triaxx.nl/api/auth.aspx?key=" + Uri.EscapeDataString(key));
                    if (!httpResponseMessage.IsSuccessStatusCode)
                    {
                        Console.WriteLine("http err: " + (int)httpResponseMessage.StatusCode);
                        Console.ReadKey();
                        return;
                    }

                    string text2 = await httpResponseMessage.Content.ReadAsStringAsync();
                    using (JsonDocument jsonDocument = JsonDocument.Parse(text2))
                    {
                        JsonElement rootElement = jsonDocument.RootElement;
                        JsonElement jsonElement;
                        if (!rootElement.TryGetProperty("success", out jsonElement) || !jsonElement.GetBoolean())
                        {
                            Console.WriteLine("api failure:");
                            Console.WriteLine(text2);
                            Console.ReadKey();
                            return;
                        }

                        JsonElement jsonElement2;
                        if (!rootElement.TryGetProperty("data", out jsonElement2))
                        {
                            Console.WriteLine("missing data:");
                            Console.WriteLine(text2);
                            Console.ReadKey();
                            return;
                        }

                        JsonElement jsonElement3;
                        string text3 = (jsonElement2.TryGetProperty("username", out jsonElement3) ? jsonElement3.GetString() : "Unknown");
                        JsonElement jsonElement4;
                        long num = (jsonElement2.TryGetProperty("id", out jsonElement4) ? jsonElement4.GetInt64() : (-1L));
                        Console.WriteLine("Welcome to TRIAXX, " + text3 + "!");

                        string text4 = Path.Combine(AppContext.BaseDirectory, "client");
                        ProcessStartInfo processStartInfo = new ProcessStartInfo();
                        processStartInfo.FileName = Path.Combine(text4, "Triaxx.exe");
                        processStartInfo.Arguments = "-script \"dofile('http://triaxx.nl/Game/Join.ashx?ID=" + num + "&GID=" + gid + "&key=" + Uri.EscapeDataString(key) + "')\"";
                        processStartInfo.WorkingDirectory = text4;
                        processStartInfo.UseShellExecute = false;

                        Process process = Process.Start(processStartInfo);

                        if (checkDisc())
                        {
                            try
                            {
                                discord = new DiscordRpcClient("1515607739034763274");
                                discord.Logger = new ConsoleLogger
                                {
                                    Level = LogLevel.Warning
                                };
                                discord.Initialize();
                                discord.SetPresence(new RichPresence
                                {
                                    Details = "Playing as " + text3,
                                    State = "In Game",
                                    Timestamps = Timestamps.Now
                                });
                            }
                            catch
                            {
                                if (discord != null)
                                {
                                    discord.Dispose();
                                }
                                discord = null;
                            }
                        }

                        if (process != null)
                        {
                            process.WaitForExit();
                        }
                        else
                        {
                            Console.WriteLine("failed to start Triaxx");
                            Console.ReadKey();
                        }
                    }
                }
            }
            catch (HttpRequestException ex2)
            {
                Console.WriteLine("req failed: " + ex2.Message);
                Console.ReadKey();
            }
            catch (JsonException ex3)
            {
                Console.WriteLine("jSON error: " + ex3.Message);
                Console.ReadKey();
            }
            catch (Exception ex4)
            {
                Console.WriteLine("error: " + ex4.Message);
                Console.ReadKey();
            }
            finally
            {
                if (discord != null)
                {
                    discord.Dispose();
                }
            }
        }
    }
}