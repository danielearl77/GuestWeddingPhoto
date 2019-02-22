<?php

if(!isset($_SESSION)){session_start();}
$PIN = $_SESSION['guestWeddingPIN'];

$sanPIN = (int)$PIN;
$dir = '../uploads/' . $sanPIN;

if (file_exists($dir) == 1) {
   $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");

    foreach ($_FILES["file"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) 
        {
            $temp = explode(".", $_FILES["file"]["name"][$key]);
            $extension = end($temp);

            $currenttime = date("Ymd-His");
            $randBit = rand(1, 9000);
            $ext = "." . $extension;
            $name = $randBit . "-" . $currenttime . $ext;

            $tmp_name = $_FILES["file"]["tmp_name"][$key];
            
            if (in_array($extension, $allowedExts))
            {
                move_uploaded_file($tmp_name, "$dir/$name");
                $msg = 'Thank You: Photos Uploaded';
                $style = 'photo-yes';
            } else {
                $msg = 'ERROR: File not image file.';
                $style = 'photo-no';
            }
        } else {
            $msg = 'ERROR: Something has gone wrong uploading your photos.  Please check and try again.  If you keep experiancing problems please contact us using our contact form.';
            $style = 'photo-no';
        }
    } // end foreach
    
} else {
    $msg = 'ERROR: Wedding PIN does not exist';
    $style = 'photo-no';
}

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta lang="en">
		<meta name="viewport" content="width=device-width">
        <link rel="icon" type="image/png" href="../images/favicon.png">
		<link rel="stylesheet" type="text/css" href="../css/gwp-reset.min.css">
        <link rel="stylesheet" type="text/css" href="../css/gwp-resp.css">
		<link rel="stylesheet" type="text/css" href="../css/gwp-style.css">

		<title>Guest Wedding Photo | Upload Wedding Photos</title>
        
        
        
        
    </head>
    
    <body>
        <header>
            <div class="row nav-bar">
                <div class="column-3"><a href="../index.html"><img src="../images/logo.png" alt="logo"></a></div>
                <div class="column-6">
                    <nav>
                        <a href="../index.html">Home</a>
                        <a href="../index.html#contact">Contact Us</a>
                        <a href="#help">Help</a>
                    </nav>
                </div>
            </div>
        </header>
        <section id="upload">
            <div class="column-3"></div>
                
            <div class="column-6">
                <div id="upload-photos-form" class="card">
                    <h3>Upload Photos</h3>
                    <p class="<?php echo $style;?>"><?php echo $msg ?></p>         
                </div>                
            </div>
                
            <div class="column-3"></div>
        </section>
        
        <section id="help">            
            <h3>Help Uploading Photos</h3>
            <p>Your photos should be in one of the following formats <span class="code">.png .jpeg .jpg</span> or <span class="code">.gif</span>.  The file size of the photos must not exceed 10mb per photo.</p> 

            <p>If you have taken your photos using a digital camera or mobile phone they should meet these requirements without you having to do anything else.  If your internet connection is slow or unreliable that can also cause problems uploading photos.</p>  

            <p>Please also check that you are using the correct wedding PIN, as provided at the wedding.</p>

            <p>If your photos are the correct size and format, your internet connection is good, and the PIN is correct but your photos still won’t upload then please contact us using the contact form and we will look into it for you.</p>	
        </section>
        
        <footer>
            <div class="row">
                <div class="column-4">
                    <a href="index.html">Back to Top</a>
                    <a href="legal.html">Terms and Conditions</a>
                    <a href="https://www.twitter.com/GuestWedding" target="_blank"><img id="twitter-link" src="../images/TwitterLogo.png" alt="twitter"></a>
                </div>
                <div class="column-8">
                    <p>Guest Wedding Photo &copy;2015 - 2018</p>
                </div>
            </div>
        </footer>
    </body>
</html>