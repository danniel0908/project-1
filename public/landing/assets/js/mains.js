document.addEventListener('DOMContentLoaded', () => {
    // function formatDate(date) {
    //   const options = {
    //     weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
    //     hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true
    //   };
    //   return date.toLocaleString('en-US', options);
    // }

    // function updateDateTime() {
    //   const currentDate = new Date();
    //   const formattedCurrentDate = formatDate(currentDate);
    //   document.getElementById('dateTime').textContent = formattedCurrentDate;
    // }

    // updateDateTime();
    // setInterval(updateDateTime, 1000);

    //REGISTER HIDDEN PASS
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
      togglePassword.addEventListener('click', () => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.classList.toggle('bi-eye');
        togglePassword.classList.toggle('bi-eye-slash');
      });
    }

    // Toggle Password Visibility for the Confirm Password Field
    const togglePassword1 = document.querySelector('#togglePassword1');
    const password1 = document.querySelector('#password1');

    if (togglePassword1 && password1) {
      togglePassword1.addEventListener('click', () => {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        togglePassword1.classList.toggle('bi-eye');
        togglePassword1.classList.toggle('bi-eye-slash');
      });
    }

    

    // const registerForm = document.getElementById('registerForm');
    // if (registerForm) {
    //   registerForm.addEventListener('submit', reg);
    // }
  });
