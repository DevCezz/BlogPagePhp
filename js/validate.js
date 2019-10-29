function validateCreateUserForm(form) {
    var userName = form.userName.value;
    var password = form.password.value;
    var repeatedPassword = form.repeatedPassword.value;
    var email = form.email.value;
    var errorSpan = document.getElementById("errorMessage");

    if (isEmpty(userName) || isEmpty(password) || isEmpty(repeatedPassword) || isEmpty(email)) {
        errorSpan.innerHTML = "Nie wypełniono wszystkich pól!";
        return false;
    }

    if (!validUserName(userName)) {
        errorSpan.innerHTML = "Nazwa użytkownia może składać się tylko ze znaków alfanumerycznych!";
        return false;
    }

    if (password !== repeatedPassword) {
        errorSpan.innerHTML = "Podane hasła nie pasują do siebie!";
        return false;
    }

    if (!validEmail(email)) {
        errorSpan.innerHTML = "Adres email jest nieprawidłowy!";
        return false;
    }

    return true;
}

function validateEditUserForm(form) {
    var userName = form.userName.value;
    var password = form.password.value;
    var repeatedPassword = form.repeatedPassword.value;
    var email = form.email.value;
    var errorSpan = document.getElementById("errorMessage");

    if (isEmpty(userName) || isEmpty(email)) {
        errorSpan.innerHTML = "Pozostawiono puste pola: nazwa użytkowniak lub email!";
        return false;
    }

    if (!validUserName(userName)) {
        errorSpan.innerHTML = "Nazwa użytkownia może składać się tylko ze znaków alfanumerycznych!";
        return false;
    }

    if (!validEmail(email)) {
        errorSpan.innerHTML = "Adres email jest nieprawidłowy!";
        return false;
    }

    if (!isEmpty(password) !== !isEmpty(repeatedPassword)) {
        errorSpan.innerHTML = "Nie wypełniono jednego z pól dotyczących hasła!";
        return false;
    }

    if (!isEmpty(password) && password !== repeatedPassword) {
        errorSpan.innerHTML = "Podane hasła nie pasują do siebie!";
        return false;
    }

    return true;
}

function validateLoginForm(form) {
    var userName = form.userName.value;
    var password = form.password.value;
    var errorSpan = document.getElementById("errorMessage");

    if (isEmpty(userName) || isEmpty(password)) {
        errorSpan.innerHTML = "Nie wypełniono wszystkich pól!";
        return false;
    }

    return true;
}

function validatePostForm(form) {
    var title = form.title.value;
    var content = form.content.value;
    var errorSpan = document.getElementById("errorMessage");

    if (isEmpty(title) || isEmpty(content)) {
        errorSpan.innerHTML = "Nie wypełniono wszystkich pól!";
        return false;
    }

    if (hasSriptTag(title) || hasSriptTag(content)) {
        errorSpan.innerHTML = "Usuń 'script tags' z pól!";
        return false;
    }

    return true;
}

function isEmpty(string) {
    return (!string || 0 === string.length);
}

function validUserName(userName) {
    regex = /^\w+$/;
    return regex.test(userName);
}

function validEmail(mail) {
    regex = /^\w+@[a-zA-Z]+\.[a-zA-Z]+$/;
    return regex.test(mail);
}

function hasSriptTag(content) {
    var scriptTagRegex = /<script(.*?)>(.*?)<\/script>/gi;
    return scriptTagRegex.test(content);
}