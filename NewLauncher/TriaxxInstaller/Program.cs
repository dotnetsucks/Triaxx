using System;
using System.Collections.Specialized;
using System.Diagnostics;
using System.IO;
using System.Security.Principal;
using System.Web;
using Microsoft.Win32;

internal class Program
{
    private static void Main(string[] args)
    {
        try
        {
            Console.WriteLine("started");
            foreach (string text in args)
            {
                Console.WriteLine("ARG: " + text);
            }
            if (!Program.isadmin())
            {
                Program.restartadmin();
                return;
            }
            Program.install();
            Program.registeruri();
            if (args.Length != 0)
            {
                Program.handleuri(args[0]);
            }
            Console.WriteLine("triaxx successfully installed");
        }
        catch (Exception ex)
        {
            Console.WriteLine(ex.ToString());
        }
        Console.WriteLine("press enter to exit...");
        Console.ReadLine();
    }

    private static bool isadmin()
    {
        return new WindowsPrincipal(WindowsIdentity.GetCurrent()).IsInRole(WindowsBuiltInRole.Administrator);
    }

    private static void restartadmin()
    {
        Process.Start(new ProcessStartInfo
        {
            FileName = System.Reflection.Assembly.GetExecutingAssembly().Location,
            UseShellExecute = true,
            Verb = "runas"
        });
    }

    private static void install()
    {
        string text = Path.Combine(AppContext.BaseDirectory, "Triaxx");
        string text2 = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.ProgramFiles), "Triaxx");
        Console.WriteLine("installing...");
        if (!Directory.Exists(text))
        {
            Console.WriteLine("folder missing: " + text);
            return;
        }
        if (Directory.Exists(text2))
        {
            Console.WriteLine("triaxx folder already found, creating...");
            Directory.Delete(text2, true);
        }
        Directory.CreateDirectory(text2);
        Console.WriteLine("successfully created");
        foreach (string text3 in Directory.GetFiles(text, "*", SearchOption.AllDirectories))
        {
            string relativePath = GetRelativePath(text, text3);
            string text4 = Path.Combine(text2, relativePath);
            string directoryName = Path.GetDirectoryName(text4);
            if (!string.IsNullOrEmpty(directoryName))
            {
                Directory.CreateDirectory(directoryName);
            }
            File.Copy(text3, text4, true);
            Console.WriteLine("installed");
        }
    }

    private static string GetRelativePath(string fromPath, string toPath)
    {
        Uri fromUri = new Uri(fromPath + "\\");
        Uri toUri = new Uri(toPath);
        Uri relativeUri = fromUri.MakeRelativeUri(toUri);
        return Uri.UnescapeDataString(relativeUri.ToString()).Replace('/', '\\');
    }

    private static void registeruri()
    {
        try
        {
            Registry.ClassesRoot.DeleteSubKeyTree("Triaxx", false);
        }
        catch
        {
        }
        using (RegistryKey registryKey = Registry.ClassesRoot.CreateSubKey("Triaxx"))
        {
            registryKey.SetValue("", "URL:Triaxx Protocol");
            registryKey.SetValue("URL Protocol", "");
        }
        string text = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.ProgramFiles), "Triaxx", "TriaxxBootstrapper.exe");
        using (RegistryKey registryKey2 = Registry.ClassesRoot.CreateSubKey("Triaxx\\shell\\open\\command"))
        {
            registryKey2.SetValue("", "\"" + text + "\" \"%1\"");
        }
    }

    private static void handleuri(string url)
    {
        try
        {
            Uri uri = null;
            if (Uri.TryCreate(url, UriKind.Absolute, out uri))
            {
                if (string.Equals(uri.Scheme, "triaxx", StringComparison.OrdinalIgnoreCase))
                {
                    string text = uri.Host;
                    if (string.IsNullOrWhiteSpace(text))
                    {
                        text = uri.AbsolutePath.Trim('/');
                    }
                    if (string.Equals(text, "join", StringComparison.OrdinalIgnoreCase))
                    {
                        NameValueCollection nameValueCollection = HttpUtility.ParseQueryString(uri.Query ?? "");
                        string text2 = nameValueCollection.Get("key");
                        string text3 = nameValueCollection.Get("port");
                        if (!string.IsNullOrWhiteSpace(text2) && !string.IsNullOrWhiteSpace(text3))
                        {
                            string text4 = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.ProgramFiles), "Triaxx", "TriaxxBootstrapper.exe");
                            if (File.Exists(text4))
                            {
                                string text5 = "-action join -key " + text2 + " -port " + text3;
                                Process.Start(new ProcessStartInfo
                                {
                                    FileName = text4,
                                    Arguments = text5,
                                    UseShellExecute = true
                                });
                            }
                        }
                    }
                }
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine(ex.ToString());
        }
    }
}