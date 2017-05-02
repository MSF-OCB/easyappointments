@echo off

set mysql_bin_path=C:\wamp64\bin\mysql\mysql5.7.14\bin
set curl_bin_path=C:\wamp64\apps\curl\src
set sql_scripts_path=C:\wamp64\www\easyappointments\assets\sql


%mysql_bin_path%\mysql -h localhost -ueauser -Dea < %sql_scripts_path%\get_reminders.sql > result.tmp

for /F "tokens=1,2,3,4,6,7 skip=1" %%i in (result.tmp) do call :process %%i %%j %%k %%l %%m %%n
goto end
:process
set appointment_id=%1
set phone=%2
set msg=Hi %3 %4! Your appointment with Dr. %5 is scheduled for tomorrow at %6

%curl_bin_path%\curl -X POST -F "Body=%msg%" -F "From=+32460200286" -F "To=+%phone%" "https://api.twilio.com/2010-04-01/Accounts/ACe357f1873c9c7e56c423caaa47bd8180/Messages" -u "ACe357f1873c9c7e56c423caaa47bd8180:59c7f6c846a88e0d4e98e4d6fb84c74c"

%mysql_bin_path%\mysql -h localhost -ueauser -Dea -e "INSERT INTO ea.tmp_reminders_sent (id_appointment) VALUES (%appointment_id%);" 

echo Message %msg% sent to +%phone%
goto :EOF

:end
del result.tmp