import javax.swing.JOptionPane;
import java.io.*;
import java.util.List;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;

public class WeducClient {
    public static void main(String[] args)  throws IOException {
        File dir = new File("Arquivos_Weduc/$LINGUAGEM");
        if(!dir.isDirectory()) {
            // attempt to create the directory here
            boolean successful = dir.mkdirs();
            if (successful)
            {
                // creating the directory succeeded
                System.out.println("directory was created successfully");

                System.setProperty("user.dir", System.getProperty("user.dir")+"/Arquivos_Weduc/$LINGUAGEM");

                String fileURL = "$LANGUAGE_FILES_URL";
                String saveDir = System.getProperty("user.dir");
                try {
                    HttpDownloadUtility.downloadFile(fileURL, saveDir);
                } catch (IOException ex) {
                    ex.printStackTrace();
                }

                String fileZip = System.getProperty("user.dir") + "/$LINGUAGEM.zip";
                byte[] buffer = new byte[1024];
                ZipInputStream zis = new ZipInputStream(new FileInputStream(fileZip));
                ZipEntry zipEntry = zis.getNextEntry();
                while(zipEntry != null){
                    String fileName = System.getProperty("user.dir") + "/" + zipEntry.getName();
                    File newFile = new File(fileName);

                    if (zipEntry.isDirectory()) {
                        newFile.mkdirs();
                        zipEntry = zis.getNextEntry();
                        continue;
                    }

                    FileOutputStream fos = new FileOutputStream(newFile);
                    int len;
                    while ((len = zis.read(buffer)) > 0) {
                        fos.write(buffer, 0, len);
                    }
                    fos.close();
                    zipEntry = zis.getNextEntry();
                }
                zis.closeEntry();
                zis.close();

                File tempZip = new File(fileZip);
                tempZip.delete();
            } else {
                // creating the directory failed
                System.out.println("failed trying to create the directory");
            }
        } else {
            System.setProperty("user.dir", System.getProperty("user.dir")+"/Arquivos_Weduc/$LINGUAGEM");
            System.out.println("im here: " +System.getProperty("user.dir"));
        }

        String fileURL = "$DOWNLOAD_URL";
        String saveDir = System.getProperty("user.dir");
        try {
            HttpDownloadUtility.downloadFile(fileURL, saveDir);
        } catch (IOException ex) {
            ex.printStackTrace();
        }



        String comando = "$SEND_CODE";
        comando = comando.replace("diretorio", System.getProperty("user.dir"));
        if (comando.contains("porta")) {
            File jsscFile = new File("../../jssc.jar");
            if(jsscFile.exists() && !jsscFile.isDirectory()){
                String portName = (String)JOptionPane.showInputDialog(null, "Selecione a porta em que seu dispositivo esta conectado:", "W-Educ - Seletor de Portas",JOptionPane.QUESTION_MESSAGE, null,SerialPortList.getPortNames(),null);

                if (portName != null){
                    comando = comando.replace("porta",  portName);
                }
            } else {
                String jsscFileURL = "$JSSC_DOWNLOAD_URL";
                String jsscSaveDir = "../../";
                try {
                    HttpDownloadUtility.downloadFile(fileURL, saveDir);
                } catch (IOException ex) {
                    ex.printStackTrace();
                }
            }
        }

        String[] comandoSeparado = comando.split(" ");
        try {
            Process proc = new ProcessBuilder().command(comandoSeparado)
                                               .inheritIO()
                                               .start();
            int exitCode = proc.waitFor();
        } catch(Exception e) {
            e.printStackTrace();
        }
    }
}