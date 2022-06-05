<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
    <noscript>
        <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body style="margin:0;padding:0;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#fff;">
        <tr>
            <td align="center" style="padding:0;">
                <table role="presentation"
                    style="width:602px;border-collapse:collapse;border:1px solid #ccc;border-spacing:0;text-align:left;">
                    <tr>
                        <td align="center" style="padding:10px 0;  height: 50px;">
                            <img src="https://gearstn.com/images/logo-mail.png" height="40" alt="GearsTN Logo">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 30px 35px 30px;">
                            <table role="presentation"
                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <p style="margin: 20px 0; color: #718096;">Hello  {{$details['user']->company_name}} </p>
                                    <p style="margin: 20px 0; color: #718096;">You are receiving this email because
                                        we received a
                                        password reset request for your account.
                                    </p>
                                    <a href="{{$details['link']}}"
                                        style="margin: 20px 0; display: block; width: fit-content; text-align: center; background-color: #172c54;
                                        color: #fafafa; padding: 10px 25px; border-radius: 5px; text-decoration: none;">
                                        Reset Password
                                    </a>
                                    <p style="margin: 20px 0; color: #718096;">This password reset link will expire
                                        in 60 minutes.
                                    </p>
                                    <p style="margin: 20px 0; color: #718096;">If you did not request a password
                                        reset, no further action is required.
                                    </p>
                                    <p style="margin: 10px 0; color: #718096;">
                                        Regards,
                                    </p>
                                    <p style="margin: 10px 0; color: #718096;">
                                        GearsTN
                                    </p>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px ;background:#172c54;">
                            <table role="presentation"
                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                <tr>
                                    <td style="color: #fff; font-size: 16px;">
                                        © 2021 GearsTN. All rights reserved.
                                    </td>
                                    <td style="padding:0;width:50%;" align="right">
                                        <table role="presentation"
                                            style="border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a target="_blank" href="https://www.facebook.com/GearsTN"><svg
                                                            version="1.1" viewBox="0 0 56.7 56.7" width="40px"
                                                            fill="#fff">
                                                            <path class="footer-social-icon"
                                                                d="M28.3,3.7c-13.6,0-24.6,11-24.6,24.6c0,13.6,11,24.6,24.6,24.6S53,41.9,53,28.3C53,14.7,41.9,3.7,28.3,3.7z M34.9,28.2h-4.3c0,6.8,0,15.2,0,15.2h-6.3c0,0,0-8.3,0-15.2h-3v-5.4h3v-3.5c0-2.5,1.2-6.4,6.4-6.4l4.7,0v5.2c0,0-2.8,0-3.4,0 c-0.6,0-1.3,0.3-1.3,1.5v3.2h4.8L34.9,28.2z">
                                                            </path>
                                                        </svg></a>
                                                </td>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a style="margin-inline:5px" target="_blank"
                                                        href="https://www.linkedin.com/company/gearstn"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="38px" fill="#fff"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z">
                                                            </path>
                                                        </svg></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
