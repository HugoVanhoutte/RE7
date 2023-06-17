let addRecipeButton = document.querySelector("#addRecipeButton");
let number = 1;
let menuContainer = document.querySelector("#menuContainer");

addRecipeButton.addEventListener("click", function () {
    number++;
    getAllRecipes()
        .then(function (response) {
            let newRecipeLine = document.createElement("div");
            newRecipeLine.classList.add("recipeLine");
            newRecipeLine.classList.add("row");
            newRecipeLine.classList.add("my-2");
            newRecipeLine.classList.add("justify-content-center");
            let newRecipeSelectDiv = document.createElement("div");
            newRecipeSelectDiv.classList.add("col-8");
            let newSelectRecipe = document.createElement("select");
            newSelectRecipe.name = "recipe" + number;
            newSelectRecipe.classList.add("form-select");
            for (let i = 0; i < response.length; i++) {
                let newOption = document.createElement("option");
                newOption.value = response[i].id;
                newOption.innerHTML = response[i].title;
                newSelectRecipe.appendChild(newOption);
            }
            newRecipeSelectDiv.appendChild(newSelectRecipe)
            newRecipeLine.appendChild(newRecipeSelectDiv);

            let newDeleteButton = document.createElement("button");
            newDeleteButton.type = "button";
            newDeleteButton.innerHTML = "<i class=\"fa-solid fa-trash\"></i>"
            newDeleteButton.classList.add("col-2");
            newDeleteButton.classList.add("btn");
            newDeleteButton.classList.add("btn-outline-danger");

            newDeleteButton.addEventListener('click', function () {
                newRecipeLine.remove();
            })


            newRecipeLine.appendChild(newDeleteButton);
            menuContainer.appendChild(newRecipeLine);
        })
        .catch(function (error) {
            console.log(error);
        })
})

function getAllRecipes() {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", window.location.origin+"/index.php/recipe?action=getAll", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let jsonResponse = JSON.parse(xhr.responseText);
                resolve(jsonResponse);
            } else {
                reject("error");
            }
        }
        xhr.send();
    });
}

