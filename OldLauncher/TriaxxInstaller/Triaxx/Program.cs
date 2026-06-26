using Microsoft.Win32;
using System;
using System.Collections.Specialized;
using System.Diagnostics;
using System.IO;
using System.Security.Principal;
using System.Web;

namespace TriaxxInstaller
{
    internal class Program
    {
        private static void Main(string[] args)
        {
            try
            {
                Console.WriteLine("Started");
                foreach (string a in args)
                {
                    Console.WriteLine("ARG: " + a);
                }

                if (!IsAdministrator())
                {
                    RestartAsAdmin();
                    return;
                }

                InstallFromLocalFolder();
                RegisterProtocol();

                if (args.Length != 0)
                {
                    HandleProtocol(args[0]);
                }

                Console.WriteLine("Triaxx installed.");
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.ToString());
            }
            Console.WriteLine("Press ENTER to exit...");
            Console.ReadLine();
        }

        private static bool IsAdministrator()
        {
            using (WindowsIdentity identity = WindowsIdentity.GetCurrent())
            {
                WindowsPrincipal principal = new WindowsPrincipal(identity);
                return principal.IsInRole(WindowsBuiltInRole.Administrator);
            }
        }

        private static void RestartAsAdmin()
        {
            ProcessStartInfo startInfo = new ProcessStartInfo
            {
                FileName = Environment.ProcessPath ?? Environment.GetCommandLineArgs()[0],
                UseShellExecute = true,
                Verb = "runas"
            };
            Process.Start(startInfo);
        }

        private static void InstallFromLocalFolder()
        {
            string source = Path.Combine(AppContext.BaseDirectory, "Triaxx");
            string dest = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData), "Triaxx");

            if (!Directory.Exists(source))
            {
                return;
            }

            if (Directory.Exists(dest))
            {
                Directory.Delete(dest, true);
            }

            Directory.CreateDirectory(dest);

            foreach (string file in Directory.GetFiles(source, "*", SearchOption.AllDirectories))
            {
                string rel = Path.GetRelativePath(source, file);
                string target = Path.Combine(dest, rel);
                string? targetDir = Path.GetDirectoryName(target);
                if (targetDir != null)
                {
                    Directory.CreateDirectory(targetDir);
                }
                File.Copy(file, target, true);
            }
        }

        private static void RegisterProtocol()
        {
            try
            {
                Registry.ClassesRoot.DeleteSubKeyTree("Triaxx", false);
            }
            catch
            {

            }

            using (RegistryKey key = Registry.ClassesRoot.CreateSubKey("Triaxx"))
            {
                if (key != null)
                {
                    key.SetValue("", "URL:Triaxx Protocol");
                    key.SetValue("URL Protocol", "");
                }
            }

            string exePath = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData), "Triaxx", "TriaxxBootstrapper.exe");

            using (RegistryKey command = Registry.ClassesRoot.CreateSubKey("Triaxx\\shell\\open\\command"))
            {
                if (command != null)
                {
                    command.SetValue("", "\"" + exePath + "\" \"%1\"");
                }
            }
        }

        private static void HandleProtocol(string url)
        {
            try
            {
                Console.WriteLine("RAW URL: " + url);

                if (!Uri.TryCreate(url, UriKind.Absolute, out Uri? uri) || uri == null)
                {
                    return;
                }

                Console.WriteLine("Scheme: " + uri.Scheme);
                Console.WriteLine("Host: " + uri.Host);
                Console.WriteLine("Path: " + uri.AbsolutePath);
                Console.WriteLine("Query: " + uri.Query);

                if (!uri.Scheme.Equals("triaxx", StringComparison.OrdinalIgnoreCase))
                {
                    return;
                }

                string action = uri.Host;
                if (string.IsNullOrWhiteSpace(action))
                {
                    action = uri.AbsolutePath.Trim('/');
                }

                if (!action.Equals("join", StringComparison.OrdinalIgnoreCase))
                {
                    return;
                }

                NameValueCollection query = HttpUtility.ParseQueryString(uri.Query ?? "");
                string? key = query.Get("key");
                string? port = query.Get("port");

                Console.WriteLine("KEY: " + key);
                Console.WriteLine("PORT: " + port);

                if (string.IsNullOrWhiteSpace(key) || string.IsNullOrWhiteSpace(port))
                {
                    return;
                }

                string exe = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData), "Triaxx", "TriaxxBootstrapper.exe");

                if (!File.Exists(exe))
                {
                    return;
                }

                string args = "-action join -key " + key + " -port " + port;
                Process.Start(new ProcessStartInfo
                {
                    FileName = exe,
                    Arguments = args,
                    UseShellExecute = true
                });
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.ToString());
            }
        }
    }
}