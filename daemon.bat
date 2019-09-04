:: Configure this (use absolute path)
:: php cli path



set PHP=C:\xampp\php\php.exe
:: daemon.php path
set DAEMON=C:\xampp\htdocs\hris2\daemon.php

:: Execute
%PHP% %DAEMON%

:: Untuk Reminder Perpanjangan Sisa Cuti
C:\xampp\php\php-cgi.exe -f "C:\xampp\htdocs\hris2\scheduled_task\ReminderProgressPerpCuti\index.php"

:: Untuk reminder hak cuti yg akan habis
C:\xampp\php\php-cgi.exe -f "C:\xampp\htdocs\hris2\scheduled_task\PerpanjanganCutiUser\index.php"