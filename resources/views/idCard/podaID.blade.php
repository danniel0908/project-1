<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .id-card {
            width: 300px;
            height: 180px;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 10px;
            text-align: center;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .id-number {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .details {
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">TODA ID Card</div>
        <div class="id-number">ID No: {{ $custom_id }}</div>
        <div class="details">Name: {{ $name }}</div>
        <div class="details">Address: {{ $address }}</div>
        <div class="details">TODA Association: {{ $TODA_Association }}</div>
        <div class="details">Status: {{ $status }}</div>
    </div>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
  <style>
    .photo-placeholder {
            width: 90px;
            height: 90px;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            margin: 8px auto;
            overflow: hidden;
        }
        
        .photo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    :root {
      --primary-color: #006400;
      --secondary-color: #90EE90;
      --accent-color: #98FB98;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0 auto;
      max-width: 800px;
      background: #f0f0f0;
      padding: 1rem;
    }

    .card-container {
      width: 100%;
      display: table;
      border-collapse: separate;
      border-spacing: 1rem;
    }

    .card {
      width: 280px;
      padding: 12px;
      background: white;
      border-radius: 6px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      display: table-cell;
      vertical-align: top;
    }

    .wave-header, .wave-footer {
      height: 30px;
      background: var(--primary-color);
      margin: -12px -12px 12px -12px;
      border-radius: 6px 6px 0 0;
      position: relative;
      overflow: hidden;
    }

    .wave-footer {
      margin: 12px -12px -12px -12px;
      border-radius: 0 0 6px 6px;
    }

    .wave-header::after, .wave-footer::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 12px;
      background: var(--secondary-color);
      clip-path: polygon(0 100%, 100% 100%, 100% 0, 70% 50%, 30% 50%, 0 0);
    }

    .logo {
      background: var(--secondary-color);
      color: var(--primary-color);
      padding: 2px 8px;
      display: inline-block;
      border-radius: 12px;
      margin-bottom: 8px;
      font-weight: bold;
      font-size: 0.8em;
    }

    .photo-placeholder {
      width: 90px;
      height: 90px;
      border: 2px solid var(--primary-color);
      border-radius: 8px;
      margin: 8px auto;
      background: #f0f0f0;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .custom-id {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      margin: 16px 0;
    }

    label {
      display: block;
      color: #666;
      font-size: 14px;
      margin-bottom: 4px;
    }

    .input-container {
      position: relative;
      margin-top: 4px;
    }

    input {
      width: calc(100% - 16px);
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
      background-color: white;
    }

    .terms {
      padding: 0;
    }

    .terms h2 {
      color: var(--primary-color);
      margin: 0 0 12px 0;
      font-size: 16px;
    }

    .terms p {
      margin: 8px 0;
      font-size: 12px;
    }

    .signature-area {
      margin-top: 16px;
      text-align: center;
    }

    .date-fields {
      display: flex;
      gap: 12px;
      margin: 16px 0;
    }

    .date-field {
      flex: 1;
    }

    .date-field label {
      font-size: 14px;
      color: #666;
    }

    .date-field input {
      width: calc(100% - 16px);
      padding: 8px;
      font-size: 14px;
    }

    button[type="submit"] {
      background-color: var(--primary-color);
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
      font-size: 14px;
      font-weight: bold;
    }

    @media print {
      body {
        padding: 0;
        background: white;
      }
      
      .card {
        box-shadow: none;
        page-break-inside: avoid;
      }

      .card-container {
        border-spacing: 0.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="card-container">
    <!-- Front -->
    <div class="card">
      <div class="wave-header"></div>
      <div class="logo">
    <img src="assets/img/tru-picture.png" alt="LOGO">
</div>
      
<div class="photo-placeholder">
@if($photo_path)
    <img src="{{ $photo_path }}" alt="User Photo" style="width: 100px; height: 100px;">
@else
    <img src="{{ asset('path/to/default/photo.jpg') }}" alt="Default Photo" style="width: 100px; height: 100px;">
@endif
</div>
      
      <div class="custom-id">
        {{$custom_id}}
      </div>
      
      <div class="form-group">
        <label>Name:</label>
        <div class="input-container">
          <input type="text" value="{{$name}}" required>
        </div>
      </div>
      
      <div class="form-group">
        <label>Address:</label>
        <div class="input-container">
          <input type="text" value="{{$address}}" required>
        </div>
      </div>
      
      <div class="form-group">
        <label>Association:</label>
        <div class="input-container">
          <input type="text" value="{{$TODA_Association}}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Phone number:</label>
        <div class="input-container">
          <input type="text" value="{{$phone_number}}" required>
        </div>
      </div>
      
      <div class="wave-footer"></div>
    </div>

    <!-- Back -->
    <div class="card">
      <div class="wave-header"></div>
      
      <h2>Terms & Conditions</h2>
      <div class="form-group">
        <p>- By signing this form, you agree to company policies</p>
        <p>- ID card must be worn at all times during work hours</p>
        <p>- Report lost or stolen cards immediately</p>
      </div>
      
      <div class="signature-area">
        <div class="form-group">
          <label>Signature</label>
          <div class="input-container signature-line">
            <input type="text" readonly>
          </div>
        </div>
        
        <div class="date-fields">
          <div class="date-field">
            <label>Issue Date:</label>
            <input type="text" value="{{$issue_date}}" required>
          </div>
          
          <div class="date-field">
            <label>Expire Date:</label>
            <input type="text" value="{{$expiration_date}}" required>
          </div>
        </div>

        <button type="submit">POSO TRU - SAN PEDRO</button>
      </div>
      
      <div class="wave-footer"></div>
    </div>
  </div>
</body>
</html>