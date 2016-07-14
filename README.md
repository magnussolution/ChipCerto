# ChipCerto

Painel desenvolvido para administrar CHAN_DONGLE com portabilidade do site www.portabilidadecelular.com

INSTALAÇÃO:

Dependencias:
Asterisk 1.8 ou superior
Chan_dongle


PASSO A PASSO

1- Deixar seu /etc/asterisk/dongle.conf assim: 
(Você pode editar as propriedes conforme sua necessidade.)

[general]
interval=5

[defaults]
rxgain=0
txgain=0
autodeletesms=yes
resetdongle=yes
u2diag=0
usecallingpres=yes
callingpres=allowed_passed_screen
disablesms=yes
language=en
smsaspdu=yes
mindtmfgap=0
mindtmfduration=0
mindtmfinterval=0
callwaiting=no
initstate=start
dtmfmode=auto
disallow=all
allow=alaw,ulaw,gsm
context=chipcerto_in
disable=no

2- Adicionar permissao para o /etc/asterisk/manager.conf

[magnus]
secret = magnussolution
deny=0.0.0.0/0.0.0.0
permit=127.0.0.1/255.255.255.0
read = system,call,log,verbose,agent,user,config,dtmf,reporting,cdr,dialplan
write = system,call,agent,user,config,command,reporting,originate


3- Criar arquivos de configuração. (So executar os comandos abaixo)

echo '' > /etc/asterisk/chipcerto_dongle.conf
echo '[redirectchipcerto]
exten => _55341011.,1,Dial(dongle/r5/041${EXTEN:8})
    same => n,hangup()        

[chipcerto]
exten => _0ZX[6-9]X.,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Dial(SIP/portabilidadecelular/${EXTEN})
same => n,CONGESTION(0)
same => n,Hangup()' > /etc/asterisk/chipcerto_extensions.conf

echo '' > /etc/asterisk/chipcerto_extensions_in.conf

echo '[portabilidadecelular] 
     type = peer 
     fromdomain = sip.portabilidadecelular.com 
     host = sip.portabilidadecelular.com 
     port = 5060 
     defaultuser = user 
     username = user 
     fromuser = user 
     secret = pass 
     context = redirectchipcerto' > /etc/asterisk/chipcerto_sip.conf
echo '
[operadoras] 
     55341 = Tim 
     55321 = Claro 
     55331 = Oi
     55320 = Vivo 
     553 = Outras Operadoras 
[rotas] 
     55341 = r5,041,11 
     55321 = Modulo01,021,11 
     55314 = r3,031,11 
     55320 = r3,015,11 
     553 = Modulo10,015,11 
[portabilidade] 
     type = sip 
     username = user 
     password = pass 
[access] 
     username = admin 
     password = magnus 
' > /etc/asterisk/chipcerto.conf

echo '
[macro-destravaModem]
exten => s,1,Set(TRUNK=${CDR(dstchannel):7:-11})
exten => s,n,Set(TRUNK_STATUS=${SHELL(asterisk rx "core show channels" | grep ${TRUNK} | wc -l)})
exten => s,n,dongleStatus(${TRUNK},DONGLE_STATUS)
exten => s,n,Noop(DONGLE_STATUS: ${DONGLE_STATUS} - TRUNK_STATUS: ${TRUNK_STATUS})
exten => s,n,AGI(destravaModem.php,${TRUNK_STATUS},${DONGLE_STATUS},${TRUNK},1)
exten => s,n,MacroExit
' >> /etc/asterisk/extensions.conf

4- INCLUIR OS ARQUIVOS NO ASTERISK
echo '#include chipcerto_sip.conf' >> /etc/asterisk/sip.conf
echo '#include chipcerto_extensions.conf ' >> /etc/asterisk/extensions.conf
echo '#include chipcerto_extensions_in.conf ' >> /etc/asterisk/extensions.conf
echo '#include chipcerto_dongle.conf ' >> /etc/asterisk/dongle.conf


5- BAIXAR O PAINEL. dentro do diretorio web. 
CentosOS /var/www/html
Debian /var/www

git clone https://github.com/magnusbilling/ChipCerto.git

6 - Dar permissao de escrita e leitura no diretorio /etc/asterisk para o usuario do apache.
Se vc crirou o usuario asterisk na instalacao, voce pode mudar o user e group do apache.
Use estes comandos:
Em Centos:
sed -i "s/User apache/User asterisk/" /etc/httpd/conf/httpd.conf
sed -i "s/Group apache/Group asterisk/" /etc/httpd/conf/httpd.conf
Em Debian:
sed -i 's/User User ${APACHE_RUN_USER}/User asterisk/' /etc/apache2/httpd.conf
sed -i 's/Group User ${APACHE_RUN_GROUP}/Group asterisk/' /etc/apache2/httpd.conf

6- REINCIAR O APACHE
Centos
service httpd restart
Debian
service apache2 restart

7-Copiar o AGI para a pasta do asterisk
Centos
cp -rf /var/www/html/chipcerto/phpagi/* /var/lib/asterisk/agi-bin
Debian
cp -rf /var/www/chipcerto/phpagi/* /var/lib/asterisk/agi-bin

8- Permiçao do AGI
chmod +x /var/lib/asterisk/agi-bin/portabiliadecelular.php


Use o https://github.com/magnusbilling/ChipCerto/issues para informar erros.

Suporte comercial: info@portabilidadecelular.com
