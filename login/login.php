<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>LOGIN | Hoshi</title>
  <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="./assets/css/style.css?v=3">
  <link rel="shortcut icon" href="./assets/images/favicon.png" />
</head>

<body>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg ">
          <div class="card col-lg-4 mx-auto rounded-1 border">
            <div class="card-body-special px-5 py-5">
              <img class="mx-auto d-block  m-3" src="./assets/images/hoshiLogo.png" alt="logo" />
              <h3 class="card-title text-left mb-3">LOGIN</h3>
              <form class="text-light" name="login_action" id="login_action" action="" method="post">
                <div class="form-group">
                  <label>Username *</label>
                  <input type="text" class="form-control p_input rounded"  placeholder="Please Enter username ..." name="username" id="username" required>
                </div>
                <div class="form-group">
                  <label>Password *</label>
                  <input type="password" class="form-control p_input rounded"  placeholder="Please Enter Password ..." name="password" id="password"  required>
                </div>
                <div class="form-group">
                  <input type="checkbox" onclick="showPassword()">Show Password
                </div>
                <div class="form-group d-flex align-items-center justify-content-between">
                  <a href="./forgot_password.php" class="forgot-pass text-warning" style="text-decoration: none">Forgot password?</a>
                </div>
                <div class="d-flex">
                  <input id="submitCaptcha" name="login" type="submit" value="Login" class="btn btn-warning me-2 p-2 col rounded">
                  <input type="reset" value="Reset form" class="btn btn-danger p-2 col rounded">
                </div>
                <div class="d-flex mt-3">
                    <a href="../introduction/" class="text-decoration-none text-light">
                        <div class="d-flex flex-row">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            <p>help</p>
                        </div>
                    </a>
                </div>
              </form>
                
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="./assets/js/off-canvas.js"></script>
  <script src="./assets/js/hoverable-collapse.js"></script>
  <script src="./assets/js/misc.js"></script>
  <script src="./assets/js/settings.js"></script>
  <script>
      function showPassword(){
          var input = document.getElementById("password");
          if(input.type === "password"){
              input.type = "text";
          } else {
              input.type = "password";
          }
      }
  </script>
</body>

</html>