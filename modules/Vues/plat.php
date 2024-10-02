<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel de Plats</title>
    <link rel="stylesheet" href="../Vues/assets/plat.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
    <link rel="manifest" href="assets/site.webmanifest">
</head>
<body>

    <div class="carousel">
            <button id="left-arrow" class="arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="#fff" d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z"/>
            </svg>
        </button>

        <div class="dish-container">
            <img id="dish-image" src="" alt="">
            <h2 id="dish-name"></h2>
            <ul class="ingredients" id="dish-ingredients"></ul>
        </div>

        <button id="right-arrow" class="arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="#fff" d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z"/>
            </svg>
        </button>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const dishes = [
        { 
            name: "Le Latino", 
            image: "https://i.imgur.com/2v2g04q.png",
            ingredients: [
                { text: "Fromage à raclette fumé", allergen: "" },
                { text: "Tenders de poulet paprika", allergen: "(sans gluten)" },
                { text: "Patates douces rôties", allergen: "(sans allergènes)" },
                { text: "Sauce chimichurri maison", allergen: "" },
                { text: "Pépites d'or comestibles en décoration", allergen: "" }
            ]
        },
        { 
            name: "L'Asiatique", 
            image: "https://i.imgur.com/U4Mz3vt.png",
            ingredients: [
                { text: "Fromage à raclette au wasabi", allergen: "" },
                { text: "Saumon mariné façon sashimi", allergen: "(sans vinaigre)" },
                { text: "Riz sushi ou pommes de terre vapeur", allergen: "" },
                { text: "Sauce soja", allergen: "(optionnelle, sans alcool)" },
                { text: "Gingembre mariné au citron", allergen: "" }
            ]
        },
        { 
            name: "L'Africain", 
            image: "https://i.imgur.com/mmwUnEh.png",
            ingredients: [
                { text: "Fromage à raclette au lait de chèvre", allergen: "" },
                { text: "Tenders épicés marinés avec cumin, paprika, huile d'olive", allergen: "" },
                { text: "Pommes de terre vapeur", allergen: "" },
                { text: "Sauce harissa douce", allergen: "(sans vinaigre)" },
                { text: "Aubergines grillées à l'huile d'olive", allergen: "" }
            ]
        },
        { 
            name: "L'Européen", 
            image: "https://i.imgur.com/gz3TxJV.png",
            ingredients: [
                { text: "Fromage à raclette truffé", allergen: "" },
                { text: "Tenders de poulet à la moutarde de Dijon", allergen: "(marinés avec de la moutarde sans allergènes majeurs)" },
                { text: "Pommes de terre Ratte vapeur", allergen: "" },
                { text: "Champignons de Paris sautés à l'ail", allergen: "" },
                { text: "Truffe noire râpée", allergen: "" }
            ]
        },
        { 
            name: "L'Américain", 
            image: "https://i.imgur.com/OHBIYui.png",
            ingredients: [
                { text: "Fromage à raclette poivré", allergen: "" },
                { text: "Bacon croustillant veggie", allergen: "" },
                { text: "Pommes de terre Yukon Gold au four", allergen: "" },
                { text: "Sauce au boursin", allergen: "(sans vinaigre, faite avec du fromage frais sans additifs)" },
                { text: "Oignons frits croustillants", allergen: "(sans gluten)" }
            ]
        },
        { 
            name: "L'Indien", 
            image: "https://i.imgur.com/BUTRriu.png",
            ingredients: [
                { text: "Fromage à raclette au cumin", allergen: "" },
                { text: "Tenders marinés aux épices tandoori", allergen: "" },
                { text: "Pommes de terre rôties au curcuma", allergen: "" },
                { text: "Oignons frits croustillants", allergen: "(sans gluten)" },
                { text: "Coriandre fraîche en garniture", allergen: "" }
            ]
        }
    ];

    let currentIndex = 0;
    let allergensVisible = false;

    const dishImage = document.getElementById('dish-image');
    const dishName = document.getElementById('dish-name');
    const dishIngredients = document.getElementById('dish-ingredients');
    const leftArrow = document.getElementById('left-arrow');
    const rightArrow = document.getElementById('right-arrow');
    const allergenInfo = document.getElementById('allergen-info');

    function updateDish() {
        const currentDish = dishes[currentIndex];

        dishImage.src = currentDish.image;
        dishName.textContent = currentDish.name;

        dishIngredients.innerHTML = '';
        currentDish.ingredients.forEach(ingredient => {
            const li = document.createElement('li');
            li.textContent = allergensVisible && ingredient.allergen ? `${ingredient.text} ${ingredient.allergen}` : ingredient.text;
            dishIngredients.appendChild(li);
        });
    }

    leftArrow.addEventListener('click', () => {
        currentIndex = (currentIndex === 0) ? dishes.length - 1 : currentIndex - 1;
        updateDish();
    });

    rightArrow.addEventListener('click', () => {
        currentIndex = (currentIndex === dishes.length - 1) ? 0 : currentIndex + 1;
        updateDish();
    });

    allergenInfo.addEventListener('click', () => {
        allergensVisible = !allergensVisible;
        updateDish();
    });

    updateDish();
});
</script>



    <footer class="footer">
        <p id="allergen-info" style="cursor: pointer;">*sans allergènes</p>
    </footer>

        
</body>
</html>
