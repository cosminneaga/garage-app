MYGARAGEAPP 

Hi, welcome to mygarageapp, this application is working in a cloud-based environment only so that means you need to have a server installed on your machine. 

Please follow the instructions in order to set it up for the first time on your Windows machine. 

**User login details:**  

*Username: test   password: test* **Admin login details:** 

*Username: admin   password: admin* 

1. You need to have XAMPP installed, this software can be downloaded from the following link: [https://www.apachefriends.org/download.html,](https://www.apachefriends.org/download.html) please download the version 7.3.17 due to the recent upgrades on PHP 7.4.5 which doesn’t work with some parts of coding. 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.001.jpeg)

*Figure 1 Download XAMPP website* 

2. After XAMPP is installed on your machine please start the Apache server and MySQL, you don’t have to configure MySQL database as the application connection file does contain standard connection as, user: root and no password as seen in[` `*Figure 3 Connection file.*](#_page1_x69.00_y679.92) If another password or user is required please alter the files from [(*Figure 4 Connection files folder)](#_page2_x69.00_y411.92)*.* There are two connection files, one for admin and one for user *php/admin/conn.php* and *php/user/conn.php.* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.002.jpeg)

*Figure 2 XAMPP start Apache and MySQL* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.003.jpeg)

*Figure 3 Connection file* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.004.jpeg)

*Figure 4 Connection files folder* 

3. After the connection file is setup (only if needed) you have to create a database called *gdb* in your MySQL database using phmyadmin, and after import the file called *gdb.sql*, which is located in the same folder as this document. 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.005.jpeg)

*Figure 5 Click the button Admin from MySQL row in order to access your phpMyAdmin* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.006.jpeg)

*Figure 6 Create a database called gdb* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.007.jpeg)

*Figure 7 Click the button to import the file into your database* 

4. After the database is created and its data is imported please copy this folder into htdocs folder located in *C:\xampp\htdocs.* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.008.jpeg)

*Figure 8 Path to copy the application files* 

5. And finally, you can access the application using the address bar of your Edge, Mozilla, Opera or Google Chrome address bar. 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.009.png)

*Figure 9 User login page* 

![](Aspose.Words.950ef88e-bf2f-48b0-adb6-f9348bc8cf1f.010.png)

*Figure 10 admin login page* 
