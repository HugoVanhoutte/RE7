let addIngredientButton = document.querySelector("#addIngredientButton");
let ingredientsContainer = document.querySelector("#ingredients");
let currentIngredients = document.querySelectorAll("select[id^=ingredient]")
let number = currentIngredients.length;

function getAllIngredients() {
    return new Promise((resolve, reject) => {

        let xhr = new XMLHttpRequest();
        xhr.open("GET", window.location.origin+"/index.php/ingredient?action=getAll", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let jsonResponse = JSON.parse(xhr.responseText);
                resolve(jsonResponse);
            } else {
                reject("error ingredients");
            }
        }
        xhr.send();
    });
}

function getAllUnits() {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", window.location.origin+"/index.php/unit?action=getAll", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let jsonResponse = JSON.parse(xhr.responseText);
                resolve(jsonResponse);
            } else {
                reject("error units");
            }
        }
        xhr.send();
    });
}

addIngredientButton.addEventListener("click", function () {
    number++;
    let newIngredientLine = document.createElement("div");
    newIngredientLine.classList.add("ingredientLine");
    getAll(newIngredientLine);

});

function getAll(newIngredientLine) {

    getAllIngredients()
        .then(function (response) {
            let newSelectIngredient = document.createElement("select");
            newSelectIngredient.name = "ingredient" + number;
            for (let i = 0; i < response.length; i++) {
                let newOption = document.createElement("option");
                newOption.value = response[i].id;
                newOption.innerHTML = response[i].name;
                newSelectIngredient.appendChild(newOption);
            }
            newIngredientLine.appendChild(newSelectIngredient);

            let newQuantity = document.createElement("input");
            newQuantity.type = "number";
            newQuantity.min = "1";
            newQuantity.name = "quantity" + number;
            newIngredientLine.appendChild(newQuantity);

            getAllUnits()
                .then(function (response) {
                    let newSelectUnit = document.createElement("select");
                    newSelectUnit.name = "unit" + number;
                    for (let i = 0; i < response.length; i++) {
                        let newOption = document.createElement("option");
                        newOption.value = response[i].id;
                        newOption.innerHTML = response[i].name;
                        newSelectUnit.appendChild(newOption);
                    }
                    newIngredientLine.appendChild(newSelectUnit);

                    let newDeleteButton = document.createElement("button");
                    newDeleteButton.innerHTML = "Supprimer";
                    newDeleteButton.classList.add('deleteButton');
                    newDeleteButton.type = "button";

                    newIngredientLine.appendChild(newDeleteButton);
                    ingredientsContainer.appendChild(newIngredientLine);

                    newDeleteButton.addEventListener('click', function () {
                        newIngredientLine.remove();
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });
        })
        .catch(function (error) {
            console.log(error);
        });
}

let ingredientLines = document.querySelectorAll(".ingredientLine");
for (let i = 0; i < ingredientLines.length; i++) {
    let newDeleteButton = document.createElement("button");
    newDeleteButton.innerHTML = "Supprimer";
    newDeleteButton.classList.add('deleteButton');
    newDeleteButton.type = "button";
    ingredientLines[i].appendChild(newDeleteButton);
    newDeleteButton.addEventListener('click', function () {
        ingredientLines[i].remove();
    })
}