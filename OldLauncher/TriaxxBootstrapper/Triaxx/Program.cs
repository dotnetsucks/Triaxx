using System;
using System.Collections.Specialized;
using System.Diagnostics;
using System.IO;
using System.Net.Http;
using System.Text.Json;
using System.Threading;
using System.Threading.Tasks;
using System.Web;

internal class Program
{
    private static async Task Main(string[] args)
    {
        string key = null;
        int port = 0;
        bool flag = args.Length == 1 && args[0].StartsWith("triaxx://", StringComparison.OrdinalIgnoreCase);
        if (flag)
        {
            Uri uri;
            bool flag2 = Uri.TryCreate(args[0], UriKind.Absolute, out uri);
            if (flag2)
            {
                NameValueCollection query = HttpUtility.ParseQueryString(uri.Query);
                key = query["key"];
                int.TryParse(query["port"], out port);
                query = null;
            }
            uri = null;
        }
        else
        {
            int num;
            for (int i = 0; i < args.Length; i = num + 1)
            {
                string arg = args[i];
                bool flag3 = arg.StartsWith("-key", StringComparison.OrdinalIgnoreCase);
                if (flag3)
                {
                    string text;
                    if (!arg.Contains("="))
                    {
                        if (i + 1 >= args.Length)
                        {
                            text = null;
                        }
                        else
                        {
                            num = i + 1;
                            i = num;
                            text = args[num];
                        }
                    }
                    else
                    {
                        text = arg.Split('=', StringSplitOptions.None)[1];
                    }
                    key = text;
                }
                else
                {
                    bool flag4 = arg.StartsWith("-port", StringComparison.OrdinalIgnoreCase);
                    if (flag4)
                    {
                        string text2;
                        if (!arg.Contains("="))
                        {
                            if (i + 1 >= args.Length)
                            {
                                text2 = null;
                            }
                            else
                            {
                                num = i + 1;
                                i = num;
                                text2 = args[num];
                            }
                        }
                        else
                        {
                            text2 = arg.Split('=', StringSplitOptions.None)[1];
                        }
                        string value = text2;
                        int.TryParse(value, out port);
                        value = null;
                    }
                }
                arg = null;
                num = i;
            }
        }
        bool flag5 = string.IsNullOrWhiteSpace(key);
        if (flag5)
        {
            Console.WriteLine("missing key");
            Console.ReadKey();
        }
        else
        {
            try
            {
                string url;
                HttpResponseMessage response;
                string result;
                JsonElement root;
                JsonElement successEl;
                JsonElement data;
                JsonElement userEl;
                string username;
                JsonElement idEl;
                JsonElement keyEl;
                string appPath;
                using (HttpClient client = new HttpClient())
                {
                    url = "http://26.103.183.243/api/auth.aspx?key=" + Uri.EscapeDataString(key);
                    HttpResponseMessage httpResponseMessage = await client.GetAsync(url);
                    response = httpResponseMessage;
                    httpResponseMessage = null;
                    if (!response.IsSuccessStatusCode)
                    {
                        Console.WriteLine("HTTP Error: " + (int)response.StatusCode);
                        Console.ReadKey();
                        return;
                    }
                    string text3 = await response.Content.ReadAsStringAsync();
                    result = text3;
                    text3 = null;
                    using (JsonDocument doc = JsonDocument.Parse(result))
                    {
                        root = doc.RootElement;
                        if (!root.TryGetProperty("success", out successEl) || !successEl.GetBoolean())
                        {
                            Console.WriteLine("API returned failure:");
                            Console.WriteLine(result);
                            Console.ReadKey();
                            return;
                        }
                        if (!root.TryGetProperty("data", out data))
                        {
                            Console.WriteLine("Missing data object:");
                            Console.WriteLine(result);
                            Console.ReadKey();
                            return;
                        }
                        username = (data.TryGetProperty("username", out userEl) ? userEl.GetString() : "Unknown");
                        long userid = (data.TryGetProperty("id", out idEl) ? idEl.GetInt64() : -1L);
                        string text4 = (data.TryGetProperty("clikey", out keyEl) ? keyEl.GetString() : null);
                        Console.WriteLine("Username: " + username);
                        Console.WriteLine("User ID: " + userid);
                        appPath = Path.Combine(AppContext.BaseDirectory, "client", "Triaxx.exe");
                        ProcessStartInfo processStartInfo = new ProcessStartInfo();
                        processStartInfo.FileName = appPath;
                        processStartInfo.Arguments = "-script \"name='" + username + "' id=" + userid + " port=" + port + " dofile('http://triaxx.nl/scripts/Join.lua')\"";
                        processStartInfo.WorkingDirectory = Path.GetDirectoryName(appPath);
                        processStartInfo.UseShellExecute = true;
                        Process.Start(processStartInfo);
                        Console.WriteLine("Triaxx launched");
                        Thread.Sleep(3000);
                        Console.Clear();
                        Console.WriteLine("Closing window in 5 seconds...");
                        Thread.Sleep(1000);
                        Console.Clear();
                        Console.WriteLine("Closing window in 4 seconds...");
                        Thread.Sleep(1000);
                        Console.Clear();
                        Console.WriteLine("Closing window in 3 seconds...");
                        Thread.Sleep(1000);
                        Console.Clear();
                        Console.WriteLine("Closing window in 2 seconds...");
                        Thread.Sleep(1000);
                        Console.Clear();
                        Console.WriteLine("Closing window in 1 seconds...");
                        Thread.Sleep(1000);
                        Console.Clear();
                        Console.WriteLine("Closing...");
                    }
                }
            }
            catch (HttpRequestException ex)
            {
                Console.WriteLine("Request failed: " + ex.Message);
                Console.ReadKey();
            }
            catch (JsonException ex2)
            {
                Console.WriteLine("Invalid JSON: " + ex2.Message);
                Console.ReadKey();
            }
            catch (Exception ex3)
            {
                Console.WriteLine("Unexpected error: " + ex3.Message);
                Console.ReadKey();
            }
        }
    }
}