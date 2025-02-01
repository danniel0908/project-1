function formatDate(date) {
    const options = {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true
    };
    return date.toLocaleString('en-US', options);
  }
  function updateDateTime() {
    const currentDate = new Date();
    const formattedCurrentDate = formatDate(currentDate);
    document.getElementById('dateTime').textContent = formattedCurrentDate;
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);


  //LOGIN HIDDEN PASS//
const togglePassword2 = document.querySelector('#togglePassword2');
const password2 = document.querySelector('#password2');

togglePassword2.addEventListener('click', function() {
    const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
    password2.setAttribute('type', type);

    if (type === 'password') {
        togglePassword2.classList.remove('bi-eye');
        togglePassword2.classList.add('bi-eye-slash');
    } else {
        togglePassword2.classList.remove('bi-eye-slash');
        togglePassword2.classList.add('bi-eye');
    }
});




//LOGIN VALIDATION
function login(event) {
    event.preventDefault();

    const username1 = document.getElementById('username1').value.trim();
    const password2 = document.forms["LoginForm"]["password"].value;

    let isValid = true;

    // Username validation
    const usernamePattern = /^JUSTINEMALIT$/;
    if (!username1 || !usernamePattern.test(username1)) {
        document.getElementById('username1Error').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('username1Error').style.display = 'none';
    }

    // Password  validation
    const passwordPattern = /^12345$/;
    if (!password2 || !passwordPattern.test(password2)) {
        document.getElementById('passwordError2').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('passwordError2').style.display = 'none';
    }


    if (isValid) {

        Swal.fire({
            title: "Login Successful",
            text: "Welcome back!",
            icon: "success"
        }).then(() => {
            document.getElementById('LoginForm').reset();
        });
    }
}
document.getElementById('LoginForm').addEventListener('submit', login);
