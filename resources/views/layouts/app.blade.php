<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta name="theme-color" content="#6777ef"/>
    <style>
        /* CSS để căn giữa bảng trong container */
        #table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Đảm bảo bảng căn giữa theo chiều dọc */
        }

        table {
            /* Các thuộc tính CSS cho bảng */
            border-collapse: collapse;
            width: 100%;
            max-width: 600px; /* Để tránh bảng quá rộng */
        }
    </style>
</head>
<body>
<div id="app"></div>
<div id="table-container">

<table>
    <tr>
        <td bgcolor="#ffffff" align="left"
            style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
            <p style="margin: 0;">Oh it looks like you've landed on the wrong page there's nothing here!</p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="border-radius: 3px;" bgcolor="#1d80c2"><a
                                        href="https://task.pics" target="_blank"
                                        style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #1d80c2; display: inline-block;">
                                        Click here to return to the correct page</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>
</body>
</html>
