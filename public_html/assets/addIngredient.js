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
    newIngredientLine.classList.add("row");
    newIngredientLine.classList.add("my-2");
    newIngredientLine.classList.add("justify-content-center");



    getAll(newIngredientLine);
});

function getAll(newIngredientLine) {

    getAllIngredients()
        .then(function (response) {
            /****************************************INGREDIENTS****************************************************/
            //div ingredient
            let newDivIngredient = document.createElement("div");

            //bootstrap div ingredient
            newDivIngredient.classList.add("col-4");

            //select ingredient
            let newSelectIngredient = document.createElement("select");
            newSelectIngredient.name = "ingredient" + number;

            //Bootstrap ingredient select
            newSelectIngredient.classList.add("form-select");

            for (let i = 0; i < response.length; i++) {
                let newOption = document.createElement("option");
                newOption.value = response[i].id;
                newOption.innerHTML = response[i].name;
                newSelectIngredient.appendChild(newOption);
            }

            //Append to div
            newDivIngredient.appendChild(newSelectIngredient);

            //Append to line
            newIngredientLine.appendChild(newDivIngredient);


            /**********************************************QUANTITY**********************************************/
            //div quantity
            let newDivQuantity = document.createElement("div");

            //Bootstrap div quantity
            newDivQuantity.classList.add("col-2")

            //input quantity
            let newInputQuantity = document.createElement("input");
            newInputQuantity.type = "number";
            newInputQuantity.min = "1";
            newInputQuantity.name = "quantity" + number;

            //Add Bootstrap classes for quantity input
            newInputQuantity.classList.add("form-control");

            //Append to div
            newDivQuantity.appendChild(newInputQuantity);
            //Append to line
            newIngredientLine.appendChild(newDivQuantity);

            getAllUnits()
                .then(function (response) {
                    /*******************************UNIT****************************************/

                    // div unit
                    let newDivUnit = document.createElement("div");

                    //Bootstrap div unit
                    newDivUnit.classList.add("col-4");

                    //select unit
                    let newSelectUnit = document.createElement("select");
                    newSelectUnit.name = "unit" + number;

                    //Bootstrap unit select
                    newSelectUnit.classList.add("form-select");

                    for (let i = 0; i < response.length; i++) {
                        let newOption = document.createElement("option");
                        newOption.value = response[i].id;
                        newOption.innerHTML = response[i].name;
                        newSelectUnit.appendChild(newOption);
                    }

                    //Append to div
                    newDivUnit.appendChild(newSelectUnit);
                    //Append to line
                    newIngredientLine.appendChild(newDivUnit);


                    //TODO create a deleteButtonAddFunction.
                    /******************************DELETE BUTTON******************************************/
                    let newDeleteButton = document.createElement("button");
                    newDeleteButton.innerHTML = "<i class=\"fa-solid fa-trash\"></i>";
                    newDeleteButton.classList.add('deleteButton');

                    //Bootstrap delete Button
                    newDeleteButton.classList.add('col-1');
                    newDeleteButton.classList.add('btn');
                    newDeleteButton.classList.add('btn-outline-danger');
                    //newDeleteButton.classList.add('mt-4');

                    newDeleteButton.type = "button";

                    //Append to line
                    newIngredientLine.appendChild(newDeleteButton);

                    //Append to container
                    ingredientsContainer.appendChild(newIngredientLine);

                    //Delete event listener
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

//TODO create a deleteButtonAddFunction.
let ingredientLines = document.querySelectorAll(".ingredientLine");
for (let i = 0; i < ingredientLines.length; i++) {
    /******************************DELETE BUTTON******************************************/
    let newDeleteButton = document.createElement("button");
    newDeleteButton.innerHTML = "<i class=\"fa-solid fa-trash\"></i>";
    newDeleteButton.classList.add('deleteButton');

    //Bootstrap delete Button
    newDeleteButton.classList.add('col-1');
    newDeleteButton.classList.add('btn');
    newDeleteButton.classList.add('btn-outline-danger');
    //newDeleteButton.classList.add('mt-4');

    newDeleteButton.type = "button";

    //Append to line
    ingredientLines[i].appendChild(newDeleteButton);
    newDeleteButton.addEventListener('click', function () {
        ingredientLines[i].remove();
    })
}