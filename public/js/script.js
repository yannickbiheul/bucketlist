const title = document.querySelector('#title');
const description = document.querySelector('#description');
const author = document.querySelector('#author');
const titre = document.querySelector('#titre');
const bouton = document.querySelector('#bouton');

const paragraph = document.createElement('p');
paragraph.textContent = "";
paragraph.style.color = "red";
paragraph.style.fontSize = "18px";
titre.append(paragraph);

title.addEventListener('keyup', checkTitle);

function checkTitle() {
    if (title.value.length < 3) {
        paragraph.textContent = "le titre doit comporter au moins 3 caractères !";
    } else if (title.value.length >= 3) {
        paragraph.textContent = "";
    }
}

author.addEventListener('keyup', checkAuthor);

function checkAuthor() {
    if (author.value.length < 3) {
        paragraph.textContent = "l'auteur doit comporter au moins 3 caractères !";
    } else if (author.value.length >= 3) {
        paragraph.textContent = "";
    }
}