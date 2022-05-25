<?php


function ValidarAsignado($connMysql, $Telefono)
{

    $SQL  = " SELECT `AsignadoA` FROM est_gestiones WHERE telefono ='$Telefono' ";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['AsignadoA'];
}

function GetLastMessages($DataJson)
{
    $connMysql = connMysql();
    $FunctionsMySQL = new FunctionsMySQL();
    $MesageNo = 1;
    $row = $DataJson['Mensaje'];
    $rowChat = $DataJson['Chat'];
    $celular = $_SESSION['celular'];
    $picurl = (isset($DataJson['FotoPerfil'])) ? $DataJson['FotoPerfil'] : '';
    try {
        $mediaKey = (isset($row['mediaKey'])) ? $row['mediaKey'] : '';
        $isForwarded = (isset($row['isForwarded'])) ? $row['isForwarded'] : '';
        $broadcast = (isset($row['broadcast'])) ? $row['broadcast'] : '';
        $user = $rowChat['id']['user'];
        $isReadOnly = (isset($rowChat['isReadOnly'])) ? $rowChat['isReadOnly'] : '';
        $archived = (isset($rowChat['archived'])) ? $rowChat['archived'] : '';
        $dataChat = ValidateChatUser($connMysql,  $user);
        $idChat =  $dataChat['id'];
        
        $UsuarioAsignadoA = ($dataChat['asignado_a']) ? $dataChat['asignado_a'] : ValidarAsignado($connMysql, $user);
        if ((!$rowChat['isGroup'])) {
            $ArrayChat = (array(
                'server' => $rowChat['id']['server'],
                'user' => $rowChat['id']['user'],
                '_serialized' => $rowChat['id']['_serialized'],
                'name' => $rowChat['name'],
                'isGroup' => $rowChat['isGroup'],
                'isReadOnly' => $isReadOnly,
                'unreadCount' => $rowChat['unreadCount'],
                'timestamp' => $rowChat['timestamp'],
                'archived' =>  $archived,
                'pinned' => $rowChat['pinned'],
                'isMuted' => $rowChat['isMuted'],
                'muteExpiration' => $rowChat['muteExpiration'],
                'picurl' => $picurl,
                'celular' => $celular,
                'asignado_a' => $UsuarioAsignadoA ,
                'notificado' => 0,

            ));
            if ($idChat == 0) {
                $FunctionsMySQL->Insert($ArrayChat, 'cc_w_chats', $connMysql);
            } else {
                $ArrayChat['id'] = $idChat;
                $FunctionsMySQL->Update($ArrayChat, 'cc_w_chats', $connMysql);
            }
        }
        $idMessage = ValidateMessage($connMysql, $row['id']['_serialized']);
        if ($idMessage == 0) {
            if ($row['hasMedia']) {
                $rowMedia = $DataJson['MediaData'];
                $Extension = mime2ext($rowMedia['mimetype']);
                $NombreFile = 'Multi_Chat_dysat_' . md5($mediaKey) . '.' . $Extension;
                $RutaFile =  '../../php/func_chat/files/' . $user . '/' . $NombreFile;
                $RutaFileDb =  'func_chat/files/' . $user . '/' . $NombreFile;
                if (!file_exists($RutaFile)) {
                    base64ToSave('data:' . $rowMedia['mimetype'] . ';base64,' . $rowMedia['data'], $RutaFile, $Extension);
                }
            } else {
                $RutaFile =  '';
                $Extension =  '';
                $RutaFileDb = '';
            }
            $ArrayMessage = (array(
                'mediaKey' => $mediaKey,
                'user' =>   $user,
                '_serialized' => $row['id']['_serialized'],
                'id_message' => $row['id']['id'],
                '_serialized_message' => $row['id']['_serialized'],
                'ack' => $row['ack'],
                'hasMedia' => $row['hasMedia'],
                'body' => $row['body'],
                'type' => $row['type'],
                'timestamp' => $row['timestamp'],
                'From_user' => $row['from'],
                'To_user' => $row['to'],
                'isForwarded' => $isForwarded,
                'isStatus' => $row['isStatus'],
                'isStarred' => $row['isStarred'],
                'broadcast' => $broadcast,
                'fromMe' => $row['fromMe'],
                'RutaFile' => $RutaFileDb,
                'Extension' => $Extension,
                'celular' => $celular,
                'asignado_a' => $UsuarioAsignadoA,
            ));
            $FunctionsMySQL->Insert($ArrayMessage, 'cc_w_chat_messages', $connMysql);
        }
    } catch (PDOException $e) {
        $data['error'] =  $e->getMessage();
        $data['datos_ok'] = 'fail';
    }

    $data['datos_ok'] = 'success';
    return $data;
}



function GetStatusWhats($DataJson)
{
    $connMysql = connMysql();
    $FunctionsMySQL = new FunctionsMySQL();
    $rowConfig = $DataJson['Config'];
    try {
        $ArrayStatusWhats = (array(
            'QR' => $rowConfig['QR'],
            'READY' => $rowConfig['READY'],
            'AUTHENTICATED' => $rowConfig['AUTHENTICATED'],
            'AUTH_FAILURE' => $rowConfig['AUTH_FAILURE'],
            'DISCONECTED' => $rowConfig['DISCONECTED'],
            'BATTERY' => $rowConfig['BATTERY'],
            'PLUGGED' => $rowConfig['PLUGGED'],
            'id' => $rowConfig['celular'],
        ));
        if ($rowConfig['READY']) {
            $rowPhone = $DataJson['DataPhone'];
            $ArrayStatusWhats['pushname'] =  $rowPhone['pushname'];
            $ArrayStatusWhats['celular_Logged'] =  $rowPhone['me']['user'];
            $ArrayStatusWhats['device_model'] =  $rowPhone['phone']['device_model'];
            $ArrayStatusWhats['device_manufacturer'] = $rowPhone['phone']['device_manufacturer'];
            $ArrayStatusWhats['platform'] = $rowPhone['platform'];
        }
        $ArrayStatusWhats['FieldIdUpdate'] = 'celular';
        $FunctionsMySQL->Update($ArrayStatusWhats, 'cc_app_api_whats', $connMysql);
    } catch (PDOException $e) {
        $data['error'] =  $e->getMessage();
        $data['datos_ok'] = 'fail';
    }
    $data['datos_ok'] = 'success';
    return $data;
}





function ValidateMessage($connMysql, $_serialized)
{
    $SQL  = " SELECT * FROM cc_w_chat_messages WHERE _serialized='$_serialized'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($CantidadTotal > 0) {
        return $row['id'];
    } else {
        return 0;
    }
}







function mime2ext($mime)
{
    $mime_map = [
        'video/3gpp2'                                                               => '3g2',
        'video/3gp'                                                                 => '3gp',
        'video/3gpp'                                                                => '3gp',
        'application/x-compressed'                                                  => '7zip',
        'audio/x-acc'                                                               => 'aac',
        'audio/ac3'                                                                 => 'ac3',
        'application/postscript'                                                    => 'ai',
        'audio/x-aiff'                                                              => 'aif',
        'audio/aiff'                                                                => 'aif',
        'audio/x-au'                                                                => 'au',
        'video/x-msvideo'                                                           => 'avi',
        'video/msvideo'                                                             => 'avi',
        'video/avi'                                                                 => 'avi',
        'application/x-troff-msvideo'                                               => 'avi',
        'application/macbinary'                                                     => 'bin',
        'application/mac-binary'                                                    => 'bin',
        'application/x-binary'                                                      => 'bin',
        'application/x-macbinary'                                                   => 'bin',
        'image/bmp'                                                                 => 'bmp',
        'image/x-bmp'                                                               => 'bmp',
        'image/x-bitmap'                                                            => 'bmp',
        'image/x-xbitmap'                                                           => 'bmp',
        'image/x-win-bitmap'                                                        => 'bmp',
        'image/x-windows-bmp'                                                       => 'bmp',
        'image/ms-bmp'                                                              => 'bmp',
        'image/x-ms-bmp'                                                            => 'bmp',
        'application/bmp'                                                           => 'bmp',
        'application/x-bmp'                                                         => 'bmp',
        'application/x-win-bitmap'                                                  => 'bmp',
        'application/cdr'                                                           => 'cdr',
        'application/coreldraw'                                                     => 'cdr',
        'application/x-cdr'                                                         => 'cdr',
        'application/x-coreldraw'                                                   => 'cdr',
        'image/cdr'                                                                 => 'cdr',
        'image/x-cdr'                                                               => 'cdr',
        'zz-application/zz-winassoc-cdr'                                            => 'cdr',
        'application/mac-compactpro'                                                => 'cpt',
        'application/pkix-crl'                                                      => 'crl',
        'application/pkcs-crl'                                                      => 'crl',
        'application/x-x509-ca-cert'                                                => 'crt',
        'application/pkix-cert'                                                     => 'crt',
        'text/css'                                                                  => 'css',
        'text/x-comma-separated-values'                                             => 'csv',
        'text/comma-separated-values'                                               => 'csv',
        'application/vnd.msexcel'                                                   => 'csv',
        'application/x-director'                                                    => 'dcr',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/x-dvi'                                                         => 'dvi',
        'message/rfc822'                                                            => 'eml',
        'application/x-msdownload'                                                  => 'exe',
        'video/x-f4v'                                                               => 'f4v',
        'audio/x-flac'                                                              => 'flac',
        'video/x-flv'                                                               => 'flv',
        'image/gif'                                                                 => 'gif',
        'application/gpg-keys'                                                      => 'gpg',
        'application/x-gtar'                                                        => 'gtar',
        'application/x-gzip'                                                        => 'gzip',
        'application/mac-binhex40'                                                  => 'hqx',
        'application/mac-binhex'                                                    => 'hqx',
        'application/x-binhex40'                                                    => 'hqx',
        'application/x-mac-binhex40'                                                => 'hqx',
        'text/html'                                                                 => 'html',
        'image/x-icon'                                                              => 'ico',
        'image/x-ico'                                                               => 'ico',
        'image/vnd.microsoft.icon'                                                  => 'ico',
        'text/calendar'                                                             => 'ics',
        'application/java-archive'                                                  => 'jar',
        'application/x-java-application'                                            => 'jar',
        'application/x-jar'                                                         => 'jar',
        'image/jp2'                                                                 => 'jp2',
        'video/mj2'                                                                 => 'jp2',
        'image/jpx'                                                                 => 'jp2',
        'image/jpm'                                                                 => 'jp2',
        'image/jpeg'                                                                => 'jpeg',
        'image/pjpeg'                                                               => 'jpeg',
        'application/x-javascript'                                                  => 'js',
        'application/json'                                                          => 'json',
        'text/json'                                                                 => 'json',
        'application/vnd.google-earth.kml+xml'                                      => 'kml',
        'application/vnd.google-earth.kmz'                                          => 'kmz',
        'text/x-log'                                                                => 'log',
        'audio/x-m4a'                                                               => 'm4a',
        'audio/mp4'                                                                 => 'm4a',
        'application/vnd.mpegurl'                                                   => 'm4u',
        'audio/midi'                                                                => 'mid',
        'application/vnd.mif'                                                       => 'mif',
        'video/quicktime'                                                           => 'mov',
        'video/x-sgi-movie'                                                         => 'movie',
        'audio/mpeg'                                                                => 'mp3',
        'audio/mpg'                                                                 => 'mp3',
        'audio/mpeg3'                                                               => 'mp3',
        'audio/mp3'                                                                 => 'mp3',
        'video/mp4'                                                                 => 'mp4',
        'video/mpeg'                                                                => 'mpeg',
        'application/oda'                                                           => 'oda',
        'audio/ogg'                                                                 => 'ogg',
        'video/ogg'                                                                 => 'ogg',
        'application/ogg'                                                           => 'ogg',
        'font/otf'                                                                  => 'otf',
        'application/x-pkcs10'                                                      => 'p10',
        'application/pkcs10'                                                        => 'p10',
        'application/x-pkcs12'                                                      => 'p12',
        'application/x-pkcs7-signature'                                             => 'p7a',
        'application/pkcs7-mime'                                                    => 'p7c',
        'application/x-pkcs7-mime'                                                  => 'p7c',
        'application/x-pkcs7-certreqresp'                                           => 'p7r',
        'application/pkcs7-signature'                                               => 'p7s',
        'application/pdf'                                                           => 'pdf',
        'application/octet-stream'                                                  => 'pdf',
        'application/x-x509-user-cert'                                              => 'pem',
        'application/x-pem-file'                                                    => 'pem',
        'application/pgp'                                                           => 'pgp',
        'application/x-httpd-php'                                                   => 'php',
        'application/php'                                                           => 'php',
        'application/x-php'                                                         => 'php',
        'text/php'                                                                  => 'php',
        'text/x-php'                                                                => 'php',
        'application/x-httpd-php-source'                                            => 'php',
        'image/png'                                                                 => 'png',
        'image/x-png'                                                               => 'png',
        'application/powerpoint'                                                    => 'ppt',
        'application/vnd.ms-powerpoint'                                             => 'ppt',
        'application/vnd.ms-office'                                                 => 'ppt',
        'application/msword'                                                        => 'doc',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/x-photoshop'                                                   => 'psd',
        'image/vnd.adobe.photoshop'                                                 => 'psd',
        'audio/x-realaudio'                                                         => 'ra',
        'audio/x-pn-realaudio'                                                      => 'ram',
        'application/x-rar'                                                         => 'rar',
        'application/rar'                                                           => 'rar',
        'application/x-rar-compressed'                                              => 'rar',
        'audio/x-pn-realaudio-plugin'                                               => 'rpm',
        'application/x-pkcs7'                                                       => 'rsa',
        'text/rtf'                                                                  => 'rtf',
        'text/richtext'                                                             => 'rtx',
        'video/vnd.rn-realvideo'                                                    => 'rv',
        'application/x-stuffit'                                                     => 'sit',
        'application/smil'                                                          => 'smil',
        'text/srt'                                                                  => 'srt',
        'image/svg+xml'                                                             => 'svg',
        'application/x-shockwave-flash'                                             => 'swf',
        'application/x-tar'                                                         => 'tar',
        'application/x-gzip-compressed'                                             => 'tgz',
        'image/tiff'                                                                => 'tiff',
        'font/ttf'                                                                  => 'ttf',
        'text/plain'                                                                => 'txt',
        'text/x-vcard'                                                              => 'vcf',
        'application/videolan'                                                      => 'vlc',
        'text/vtt'                                                                  => 'vtt',
        'audio/x-wav'                                                               => 'wav',
        'audio/wave'                                                                => 'wav',
        'audio/wav'                                                                 => 'wav',
        'application/wbxml'                                                         => 'wbxml',
        'video/webm'                                                                => 'webm',
        'image/webp'                                                                => 'webp',
        'audio/x-ms-wma'                                                            => 'wma',
        'application/wmlc'                                                          => 'wmlc',
        'video/x-ms-wmv'                                                            => 'wmv',
        'video/x-ms-asf'                                                            => 'wmv',
        'font/woff'                                                                 => 'woff',
        'font/woff2'                                                                => 'woff2',
        'application/xhtml+xml'                                                     => 'xhtml',
        'application/excel'                                                         => 'xl',
        'application/msexcel'                                                       => 'xls',
        'application/x-msexcel'                                                     => 'xls',
        'application/x-ms-excel'                                                    => 'xls',
        'application/x-excel'                                                       => 'xls',
        'application/x-dos_ms_excel'                                                => 'xls',
        'application/xls'                                                           => 'xls',
        'application/x-xls'                                                         => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/vnd.ms-excel'                                                  => 'xlsx',
        'application/xml'                                                           => 'xml',
        'text/xml'                                                                  => 'xml',
        'text/xsl'                                                                  => 'xsl',
        'application/xspf+xml'                                                      => 'xspf',
        'application/x-compress'                                                    => 'z',
        'application/x-zip'                                                         => 'zip',
        'application/zip'                                                           => 'zip',
        'application/x-zip-compressed'                                              => 'zip',
        'application/s-compressed'                                                  => 'zip',
        'multipart/x-zip'                                                           => 'zip',
        'text/x-scriptzsh'                                                          => 'zsh',
        'audio/ogg; codecs=opus'                                                    => 'ogg',
    ];

    return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
}



function base64ToSave($base64_string, $output_file, $extension)
{
    $temp = time() . '.' . $extension;
    $file = fopen($temp, "wb");

    $data = explode(',', $base64_string);

    fwrite($file, base64_decode($data[1]));
    fclose($file);
    CopyFiles($temp, $output_file);
    unlink($temp);
    return;
}


function CopyFiles($RutaLocalTrk, $RutaLocalApi)
{
    error_reporting(E_ERROR | E_PARSE);

    $path = pathinfo($RutaLocalApi);
    if (!file_exists($path['dirname'])) {
        mkdir($path['dirname'], 0755, true);
    }

    if (copy($RutaLocalTrk, $RutaLocalApi)) {

        if (file_exists($RutaLocalApi)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function ValidateChatUser($connMysql, $user)
{

    $celular = $_SESSION['celular'];
    $SQL  = " SELECT * FROM cc_w_chats WHERE user='$user'";
    $stmt = $connMysql->prepare($SQL);
    $stmt->execute();
    $CantidadTotal = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($CantidadTotal > 0) {
        return $row;
    } else {
        return 0;
    }
}
