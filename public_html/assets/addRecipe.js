let addRecipeButton = document.querySelector("#addRecipeButton");
let number = 1;
let menuContainer = document.querySelector("#menuContainer");

addRecipeButton.addEventListener("click", function () {
    number++;
    getAllRecipes()
        .then(function (response) {
            let newRecipeLine = document.createElement("div");
            newRecipeLine.classList.add("recipeLine");
            let newSelectRecipe = document.createElement("select");
            newSelectRecipe.name = "recipe" + number;
            for (let i = 0; i < response.length; i++) {
                let newOption = document.createElement("option");
                newOption.value = response[i].id;
                newOption.innerHTML = response[i].title;
                newSelectRecipe.appendChild(newOption);
            }
            newRecipeLine.appendChild(newSelectRecipe);

            let newDeleteButton = document.createElement("button");
            newDeleteButton.type = "button";


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

