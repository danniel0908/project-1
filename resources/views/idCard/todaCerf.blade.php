

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pdf-wrapper" id="card-content">
    <div class="card-container">
        <div class="header">
            <div class="logo">
           <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('landing/assets/img/san pedro.png'))) }}" alt="City of San Pedro"  class="san-pedro-logo">
            </div>
            <div class="title">
                <p style = "font-size: 17px; margin-left: 50px; letter-spacing: 3px">Republic of the Philippines</p>
                <h1 style = "margin-left: 100px; letter-spacing: 1px;">City of San Pedro</h1>
                <p style = "margin-left: 100px;">PROVINCE OF LAGUNA</p>
                <p style = "margin-left: 100px;">Tel No. 808-2020 Loc. 211</p>
                <h1 style = "width: 400px">PUBLIC ORDER AND SAFETY OFFICE (POSO)</h1>
                <h1 style = "letter-spacing: 2px; width: 400px">Transportation Regulatory Unit (TRU)</h1>
            </div>
            <div>
            <img src="{{ public_path('landing/assets/img/tru-picture.png') }}" alt="TRU Logo" class="tru-logo"  style = "position: relative; left: 570px; bottom: 250px; ">
            </div>
        </div>
 <div style = "position: relative; bottom: 250px; border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid;"></div>
    <div style = "position: relative; bottom: 230px;">
        <div style = "margin-bottom: 20px;">
            <h1 style="font-size: 17px; text-align: center; font-weight: bold;">Special Authority</h1>
            <h1 style="font-size: 15px; text-align: center; ">(Certificaite of Franchise for Tricycle for Hire)</h1>
        </div>
        <div>
            <h1 style="font-size: 15px; text-align: center; ">Franchse No. <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
            <h1 style="font-size: 15px; text-align: center; line-height: 30px;">Period Covered <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
        </div>
        <div class="right-section">
            <div class="photo-placeholder">
            </div>
        </div>

        <div class="card-body">
            <div class="left-section">
                <p>City Municipality: San Pedro</p>
                <p><strong>Applicant: {{ $name }}</strong></p>
                <p>Drivers Name:{{ $driver_first_name }} {{ $driver_last_name }}</p>
                <p>Address: {{ $address }}</p>
            </div>
        </div>

        <div>
            <h1 style="font-size: 17px; margin-left: 30px; font-weight: bold; height: 70px;">Toda Name: {{ $TODA_Association }}</h1>
        </div>
     <div style = "display: flex; justify-content: center; align-items: center; height: 130px;">
        <div style = "display: grid; grid-template-columns: 100px 150px 150px 100px;">
            <p>Make: <span> {{ $Make }} </span></p>
            <p style = "position: relative; left: 150px; bottom: 20px;"> Motor No:  <span>{{ $Engine_no }}</span></p>
            <p style = "position: relative; left: 350px; bottom: 40px;">Chasis No: <span> {{ $Chassis_no }}</span></p>
            <p style = "position: relative; left: 550px; bottom: 60px;">Plate No: <span>{{ $Plate_no }} </span></p>
            <div style = "width: 220px;"> 
            <p style = "font-weight: bold; font-size: 16px;">Recommending Approval</p>
            <p style = "margin-top: 40px;">Officer in-Charge TRU</p>
        </div>
            <p style = "position: relative; left: 500px; bottom: 60px;">Approved By</p>
        </div>
    </div>
        <div class="footer">
            <p style = "font-weight: bold;">HON. ART JOSEPH FRANCIS MERCADO</p>
            <p style = "position: relative; right: 100px;">CITY MAYOR</p>
        </div>
    </div>
    </div>

</div>

    

    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .pdf-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }
        
        .card-container {
            width: 680px; /* Increased width */
            background-color: #fff;
            padding: 30px; /* Increased padding */
            border-radius: 15px; /* Increased border-radius for smoother corners */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* More pronounced shadow */
            height: 90%
        }
        
        .header {
            display: grid;
            grid-template-columns: 220px 430px 150px;
        }
        
        .logo img {
            width: 100px; /* Larger logo */
            height: 100px;
        }
        
        .title {
            margin-left: 180px;
            position: relative;
            bottom: 120px;
           
        }
        
        .title h1 {
            font-size: 16px; /* Increased font size */
            color: #333;
            width: 350px;
        }
        
        .title p {
            font-size: 13px; /* Increased font size */
            color: #666;
            width: 300px;
            line-height: 20px;
        
        }
        
        .card-body {
            position: relative;
            bottom: 20px;
        }
        
        .left-section {
            width: 60%;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .left-section p {
            margin-bottom: 10px; /* Increased space between text */
        }
        
        .tru-logo {
            width: 155px; /* Larger TRU logo */
            height: 150px;
         
        }
        
        .right-section {
            position: relative;
            left: 490px;
            bottom: 125px;
        }
        
        .photo-placeholder {
            width: 170px; /* Larger photo placeholder */
            height: 130px;
            border: 3px solid #333; /* Thicker border around photo */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px; /* Increased font size */
            color: #666;
            margin-bottom: 15px;
            border-radius: 15px;
            margin-left: 30px;
            border-color: #01360d;
            margin-top: 5px;
        }
        
        .footer {
            text-align: right;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .footer p {
            margin-top: 10px;
        }
        .download-section {
            text-align: center;
        }
        
        #download-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #download-btn:hover {
            background-color: #218838;
        }
        
    </style>
</body>
</html>


<!-- PODA FOR HIRE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pdf-wrapper" id="card-content">
    <div class="card-container">
        <div class="header">
            <div class="logo">
           <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('landing/assets/img/san pedro.png'))) }}" alt="City of San Pedro"  class="san-pedro-logo">
            </div>
            <div class="title">
                <p style = "font-size: 17px; margin-left: 50px; letter-spacing: 3px">Republic of the Philippines</p>
                <h1 style = "margin-left: 100px; letter-spacing: 1px;">City of San Pedro</h1>
                <p style = "margin-left: 100px;">PROVINCE OF LAGUNA</p>
                <p style = "margin-left: 100px;">Tel No. 808-2020 Loc. 211</p>
                <h1 style = "width: 400px">PUBLIC ORDER AND SAFETY OFFICE (POSO)</h1>
                <h1 style = "letter-spacing: 2px; width: 400px">Transportation Regulatory Unit (TRU)</h1>
            </div>
            <div>
            <img src="{{ public_path('landing/assets/img/tru-picture.png') }}" alt="TRU Logo" class="tru-logo"  style = "position: relative; left: 570px; bottom: 250px; ">
            </div>
        </div>
 <div style = "position: relative; bottom: 250px; border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid;"></div>
    <div style = "position: relative; bottom: 230px;">
        <div style = "margin-bottom: 20px;">
            <h1 style="font-size: 17px; text-align: center; font-weight: bold;">Special Authority</h1>
            <h1 style="font-size: 15px; text-align: center; ">(Certificaite of Franchise for Pedicab for Hire)</h1>
        </div>
        <div>
            <h1 style="font-size: 15px; text-align: center; ">Franchse No. <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
            <h1 style="font-size: 15px; text-align: center; line-height: 30px;">Period Covered <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
        </div>
        <div class="right-section">
            <div class="photo-placeholder">
            </div>
        </div>

        <div class="card-body">
            <div class="left-section">
                <p>City Municipality: San Pedro</p>
                <p><strong>Applicant: {{ $name }}</strong></p>
                <p>Case No:</p>
                <p>Address: {{ $address }}</p>
            </div>
        </div>

        <div>
            <h1 style="font-size: 17px; margin-left: 30px; font-weight: bold; height: 70px;">Toda Name: {{ $TODA_Association }}</h1>
        </div>
     <div style = "display: flex; justify-content: center; align-items: center; height: 130px;">
        <div style = "display: grid; grid-template-columns: 100px 150px 150px 100px;">
            <p>Make: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 90px; font-size: 12px"> {{ $Make }} </span></p>
            <p style = "position: relative; left: 150px; bottom: 20px;"> Motor No:  <span style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 70px; font-size: 12px;">{{ $Engine_no }}</span></p>
            <p style = "position: relative; left: 350px; bottom: 40px;">Chasis No: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 70px; font-size: 12px;"> {{ $Chassis_no }}</span></p>
            <p style = "position: relative; left: 550px; bottom: 60px;">Plate No: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 60px; font-size: 12px;">{{ $Plate_no }} </span></p>
           <div style = "width: 220px;"> 
            <p style = "font-weight: bold; font-size: 16px;">Recommending Approval</p>
            <p style = "margin-top: 40px;">Officer in-Charge TRU</p>
        </div>
            <p style = "position: relative; left: 500px; bottom: 60px;">Approved By</p>
        </div>
    </div>
        <div class="footer">
            <p style = "font-weight: bold;">HON. ART JOSEPH FRANCIS MERCADO</p>
            <p style = "position: relative; right: 100px;">CITY MAYOR</p>
        </div>
    </div>
    </div>

</div>

    

    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .pdf-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }
        
        .card-container {
            width: 680px; /* Increased width */
            background-color: #fff;
            padding: 30px; /* Increased padding */
            border-radius: 15px; /* Increased border-radius for smoother corners */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* More pronounced shadow */
            height: 90%
        }
        
        .header {
            display: grid;
            grid-template-columns: 220px 430px 150px;
        }
        
        .logo img {
            width: 100px; /* Larger logo */
            height: 100px;
        }
        
        .title {
            margin-left: 180px;
            position: relative;
            bottom: 120px;
           
        }
        
        .title h1 {
            font-size: 16px; /* Increased font size */
            color: #333;
            width: 350px;
        }
        
        .title p {
            font-size: 13px; /* Increased font size */
            color: #666;
            width: 300px;
            line-height: 20px;
        
        }
        
        .card-body {
            position: relative;
            bottom: 20px;
        }
        
        .left-section {
            width: 60%;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .left-section p {
            margin-bottom: 10px; /* Increased space between text */
        }
        
        .tru-logo {
            width: 155px; /* Larger TRU logo */
            height: 150px;
         
        }
        
        .right-section {
            position: relative;
            left: 490px;
            bottom: 125px;
        }
        
        .photo-placeholder {
            width: 170px; /* Larger photo placeholder */
            height: 130px;
            border: 3px solid #333; /* Thicker border around photo */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px; /* Increased font size */
            color: #666;
            margin-bottom: 15px;
            border-radius: 15px;
            margin-left: 30px;
            border-color: #01360d;
            margin-top: 5px;
        }
        
        .footer {
            text-align: right;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .footer p {
            margin-top: 10px;
        }
        .download-section {
            text-align: center;
        }
        
        #download-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #download-btn:hover {
            background-color: #218838;
        }
        
    </style>
</body>
</html>


-->


<!-- Service TRICYCLE FOR HIRE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pdf-wrapper" id="card-content">
    <div class="card-container">
        <div class="header">
            <div class="logo">
           <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('landing/assets/img/san pedro.png'))) }}" alt="City of San Pedro"  class="san-pedro-logo">
            </div>
            <div class="title">
                <p style = "font-size: 17px; margin-left: 50px; letter-spacing: 3px">Republic of the Philippines</p>
                <h1 style = "margin-left: 100px; letter-spacing: 1px;">City of San Pedro</h1>
                <p style = "margin-left: 100px;">PROVINCE OF LAGUNA</p>
                <p style = "margin-left: 100px;">Tel No. 808-2020 Loc. 211</p>
                <h1 style = "width: 400px">PUBLIC ORDER AND SAFETY OFFICE (POSO)</h1>
                <h1 style = "letter-spacing: 2px; width: 400px">Transportation Regulatory Unit (TRU)</h1>
            </div>
            <div>
            <img src="{{ public_path('landing/assets/img/tru-picture.png') }}" alt="TRU Logo" class="tru-logo"  style = "position: relative; left: 570px; bottom: 250px; ">
            </div>
        </div>
 <div style = "position: relative; bottom: 250px; border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid;"></div>
    <div style = "position: relative; bottom: 230px;">
        <div style = "margin-bottom: 20px;">
            <h1 style="font-size: 17px; text-align: center; font-weight: bold;">Special Authority</h1>
            <h1 style="font-size: 15px; text-align: center; ">(Certificaite of Franchise for Service Tricycle for Hire)</h1>
        </div>
        <div>
            <h1 style="font-size: 15px; text-align: center; ">Franchse No. <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
            <h1 style="font-size: 15px; text-align: center; line-height: 30px;">Period Covered <div style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 105px; font-size: 12px; position: relative; left: 400px;"></div></h1>
        </div>
        <div class="right-section">
            <div class="photo-placeholder">
            </div>
        </div>

        <div class="card-body">
            <div class="left-section">
                <p>City Municipality: San Pedro</p>
                <p><strong>Applicant: {{ $name }}</strong></p>
                <p>Case No:</p>
                <p>Address: {{ $address }}</p>
            </div>
        </div>

        <div>
            <h1 style="font-size: 17px; margin-left: 30px; font-weight: bold; height: 70px;">Toda Name: {{ $TODA_Association }}</h1>
        </div>
     <div style = "display: flex; justify-content: center; align-items: center; height: 130px;">
        <div style = "display: grid; grid-template-columns: 100px 150px 150px 100px;">
            <p>Make: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 90px; font-size: 12px"> {{ $Make }} </span></p>
            <p style = "position: relative; left: 150px; bottom: 20px;"> Motor No:  <span style =" border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 70px; font-size: 12px;">{{ $Engine_no }}</span></p>
            <p style = "position: relative; left: 350px; bottom: 40px;">Chasis No: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 70px; font-size: 12px;"> {{ $Chassis_no }}</span></p>
            <p style = "position: relative; left: 550px; bottom: 60px;">Plate No: <span style = "border-bottom-color: black;  border-bottom-width: 2px;  border-bottom-style: solid; width: 60px; font-size: 12px;">{{ $Plate_no }} </span></p>
           <div style = "width: 220px;"> 
            <p style = "font-weight: bold; font-size: 16px;">Recommending Approval</p>
            <p style = "margin-top: 40px;">Officer in-Charge TRU</p>
        </div>
            <p style = "position: relative; left: 500px; bottom: 60px;">Approved By</p>
        </div>
    </div>
        <div class="footer">
            <p style = "font-weight: bold;">HON. ART JOSEPH FRANCIS MERCADO</p>
            <p style = "position: relative; right: 100px;">CITY MAYOR</p>
        </div>
    </div>
    </div>

</div>

    

    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .pdf-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }
        
        .card-container {
            width: 680px; /* Increased width */
            background-color: #fff;
            padding: 30px; /* Increased padding */
            border-radius: 15px; /* Increased border-radius for smoother corners */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* More pronounced shadow */
            height: 90%
        }
        
        .header {
            display: grid;
            grid-template-columns: 220px 430px 150px;
        }
        
        .logo img {
            width: 100px; /* Larger logo */
            height: 100px;
        }
        
        .title {
            margin-left: 180px;
            position: relative;
            bottom: 120px;
           
        }
        
        .title h1 {
            font-size: 16px; /* Increased font size */
            color: #333;
            width: 350px;
        }
        
        .title p {
            font-size: 13px; /* Increased font size */
            color: #666;
            width: 300px;
            line-height: 20px;
        
        }
        
        .card-body {
            position: relative;
            bottom: 20px;
        }
        
        .left-section {
            width: 60%;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .left-section p {
            margin-bottom: 10px; /* Increased space between text */
        }
        
        .tru-logo {
            width: 155px; /* Larger TRU logo */
            height: 150px;
         
        }
        
        .right-section {
            position: relative;
            left: 490px;
            bottom: 125px;
        }
        
        .photo-placeholder {
            width: 170px; /* Larger photo placeholder */
            height: 130px;
            border: 3px solid #333; /* Thicker border around photo */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px; /* Increased font size */
            color: #666;
            margin-bottom: 15px;
            border-radius: 15px;
            margin-left: 30px;
            border-color: #01360d;
            margin-top: 5px;
        }
        
        .footer {
            text-align: right;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .footer p {
            margin-top: 10px;
        }
        .download-section {
            text-align: center;
        }
        
        #download-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #download-btn:hover {
            background-color: #218838;
        }
        
    </style>
</body>
</html>


-->


<!--Application for Service



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/header.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 110px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/header-8.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 200px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1); position: relative; bottom: 10px; right: 20px;">
<div class="card-body">
            <div class="left-section">
                <p style = "font-size: 14px;">Name of Driver:<strong style = "margin-left: 5px;"> {{$name}}</strong</p>
                <p style = "font-size: 14px;">Address: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
                <p style = "font-size: 14px;">Contact No.: <strong style = "margin-left: 5px;"> {{ $address }}</strong></p>
                <p style = "font-size: 14px;">Gender: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
            
            </div>
            <div style = "position: relative; left: 400px; bottom: 133px;">
                <p style = "font-size: 14px;">Name of Driver:<strong style = "margin-left: 5px;"> {{$name}}</strong</p>
                <p style = "font-size: 14px;">Address: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
                <p style = "font-size: 14px;">Contact No.: <strong style = "margin-left: 5px;"> {{ $address }}</strong></p>
                <p style = "font-size: 14px;">Gender: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
            </div>
        </div>
<img src="{{ public_path('landing/assets/img/schedule.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 50%; height: 140px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1); position: relative; bottom: 80px;">
<div style = "display: flex; justify-content: center; align-items: center; height: 130px;">
        <div style = "display: grid; grid-template-columns: 100px 150px 150px 100px;">
            <p>Make: <span> {{ $Make }} </span></p>
            <p style = "position: relative; left: 150px; bottom: 34px;"> Motor No:  <span>{{ $Engine_no }}</span></p>
            <p style = "position: relative; left: 350px; bottom: 68px;">Chasis No: <span> {{ $Chassis_no }}</span></p>
            <p style = "position: relative; left: 550px; bottom: 106px;">Plate No: <span>{{ $Plate_no }} </span></p>
    </div>
</div>
<img src="{{ public_path('landing/assets/img/affidavit.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 85%; height: 182px; margin-left: 50px; image-rendering: crisp-edges; filter: contrast(1.2); brightness(1.1); ">

<style>
     .card-body {
            position: relative;
            left: 30px; 
        }
        
        .left-section {
            width: 60%;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .left-section p {
            margin-bottom: 10px; /* Increased space between text */
        }
    </style>
</body>
</html>


-->

<!--Application for PUB/PUJ/FX

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/Header-9.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 300px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<div class="card-body">
            <div class="left-section">
                <p style = "font-size: 14px;">Name of Driver:<strong style = "margin-left: 5px;"> {{$name}}</strong</p>
                <p style = "font-size: 14px;">Address: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
                <p style = "font-size: 14px;">Contact No.: <strong style = "margin-left: 5px;"> {{ $address }}</strong></p>
                <p style = "font-size: 14px;">Gender: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
                <p style = "position: relative; bottom: 260px; left: 280px; font-weight: bold;">{{ $address }}</p>
            
            </div>
            <div style = "position: relative; left: 400px; bottom: 163px;">
                <p style = "font-size: 14px;">Name of Driver:<strong style = "margin-left: 5px;"> {{$name}}</strong</p>
                <p style = "font-size: 14px;">Address: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
                <p style = "font-size: 14px;">Contact No.: <strong style = "margin-left: 5px;"> {{ $address }}</strong></p>
                <p style = "font-size: 14px;">Gender: <strong style = "margin-left: 10px;">{{ $address }}</strong></p>
            </div>
        </div>

        <style>
     .card-body {
            position: relative;
            left: 30px; 
        }
        
        .left-section {
            width: 60%;
            color: #333;
            font-size: 14px; /* Increased font size */
        }
        
        .left-section p {
            margin-bottom: 10px; /* Increased space between text */
        }
    </style>

<img src="{{ public_path('landing/assets/img/motor-1.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 280px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
                <h5 style = "font-weight: bold; margin-left: 30px; margin-top: 0; margin-bottom: 2px;">Requirements</h5>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Certificate of Ownership (Xerox)</p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Official Receipt (Xerox) </p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Insurance (Xerox) </strong></p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; BRGY Clearance (Original) </strong></p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Certificate of Franchise </p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Driver License (Xerox) </strong></p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; 2X2 Picture Operator/Driver</strong></p>
                <p style = "font-size: 12px; margin-top:0; margin-bottom: 0;">&#x2022; Voter's ID or Certificate </p>

</body>
</html>

-->

<!-- Application for Poda
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/header.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 150px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/Header-4.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 400px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/assessment.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 350px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
</body>
</html>


-->

<!-- TODA Dropping Application

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/header.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 150px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/Header-5.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 400px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/evaluation.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 350px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
</body>
</html>

-->



<!-- PODA Dropping Application
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/header.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 150px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/Header-7.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 400px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/evaluation.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 350px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
</body>
</html>

-->


<!-- Application for TODA
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU Card Design</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<img src="{{ public_path('landing/assets/img/header.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 150px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/Header-6.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 300px; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/motor-3.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 250px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
<img src="{{ public_path('landing/assets/img/assessment-1.png') }}" alt="TRU Logo" class="tru-logo"  style = "width: 100%; height: 300px; margin-top: 0; margin-bottom: 0; image-rendering: crisp-edges; filter: contrast(1.2) brightness(1.1);">
</body>
</html>

-->



