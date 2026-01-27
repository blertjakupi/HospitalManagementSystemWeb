document.addEventListener("DOMContentLoaded", function () {

    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const appointmentForm = document.getElementById("appointmentForm");
   
    if (loginForm) {
        const errorBox = document.getElementById("formError");

        loginForm.addEventListener("submit", function (e) {
            errorBox.textContent = "";

            const email = loginForm.email.value.trim();
            const password = loginForm.password.value.trim();

            if (email === "" || password === "") {
                showError("Ju lutem plotësoni të gjitha fushat!");
                e.preventDefault();
                return;
            }

            if (!validateEmail(email)) {
                showError("Email nuk është valid!");
                e.preventDefault();
                return;
            }

            if (password.length < 6) {
                showError("Fjalëkalimi duhet të ketë së paku 6 karaktere!");
                e.preventDefault();
                return;
            }
            if (password.length > 20) {
                showError("Fjalëkalimi duhet të ketë më shumë se 20 karaktere!");
                e.preventDefault();
                return;
            }
        });

        function showError(msg) {
            errorBox.textContent = msg;
        }
    }

    
    if (registerForm) {
        const errorBox = document.getElementById("formError");

        registerForm.addEventListener("submit", function (e) {
            errorBox.textContent = "";

            const username = registerForm.username.value.trim();
            const email = registerForm.email.value.trim();
            const password = registerForm.password.value.trim();
            const cpassword = registerForm.cpassword.value.trim();

            if (username === "" || email === "" || password === "" || cpassword === "") {
                showError("Ju lutem plotësoni të gjitha fushat!");
                e.preventDefault();
                return;
            }

            if (username.length < 3) {
                showError("Username duhet të ketë së paku 3 karaktere!");
                e.preventDefault();
                return;
            }

            if (!validateEmail(email)) {
                showError("Email nuk është valid!");
                e.preventDefault();
                return;
            }

            if (password.length < 6) {
                showError("Fjalëkalimi duhet të ketë së paku 6 karaktere!");
                e.preventDefault();
                return;
            }

            if (password.length > 20) {
                showError("Fjalëkalimi duhet të ketë më shumë se 20 karaktere!");
                e.preventDefault();
                return;
            }

            if (password !== cpassword) {
                showError("Fjalëkalimet nuk përputhen!");
                e.preventDefault();
                return;
            }
        });

        function showError(msg) {
            errorBox.textContent = msg;
        }
    }

    
    function validateEmail(email) {

        if (!email.includes("@")) return false;
        if (!email.includes(".")) return false;
        if (email.startsWith("@")) return false;
        if (email.endsWith(".")) return false;

        let atPosition = email.indexOf("@");
        let dotPosition = email.lastIndexOf(".");

        if (dotPosition < atPosition) return false;

        return true;
    }

      if (appointmentForm) {
        const errorBox = document.getElementById("formError");

        appointmentForm.addEventListener("submit", function (e) {
            errorBox.textContent = "";

            const fullname = appointmentForm.fullname.value.trim();
            const email = appointmentForm.email.value.trim();
            const phone = appointmentForm.phone.value.trim();
            const doctor = appointmentForm.doctor.value.trim();
            const dateValue = appointmentForm.date.value.trim();
            const time = appointmentForm.time.value.trim();
            const symptoms = appointmentForm.symptoms.value.trim();


            if (fullname === "" || email === "" || phone === "" || doctor === "" || dateValue === "" || time === "" || symptoms === "") {
                showError("Ju lutem plotësoni të gjitha fushat!");
                e.preventDefault();
                return;
            }

            
            if (!validateEmail(email)) {
                showError("Email nuk është valid!");
                e.preventDefault();
                return;
            }

            
            const phoneRegex = /^[\d\+\-\(\)\s]+$/;

            if (!phoneRegex.test(phone)) {
                showError("Numri i telefonit përmban karaktere të palejuara!");
                e.preventDefault();
                return;
            }

            if (phone.length < 6) {
                showError("Numri i telefonit duhet të ketë së paku 6 shifra!");
                e.preventDefault();
                return;
            }

            
            const selectedDate = new Date(dateValue.replace(/-/g, '\/'));
            
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                showError("Nuk mund të caktoni termin në një datë të kaluar!");
                e.preventDefault();
                return;
            }

            
        });

        function showError(msg) {
            errorBox.textContent = msg;
        }
    }

});
