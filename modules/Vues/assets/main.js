
const elements  = {
    'ferme_btn': document.getElementById("fermeBtn"),
    'ouvre_btn': document.getElementById("ouvreBtn"),
    'compte': document.getElementById("imgCompte"),
    'tender': document.getElementById("tender"),
    'menu': document.getElementById('menu')
};


const toggle_menu = (is_open) => {
    const action = is_open ? 'add' : 'remove';

    ['menu', 'ferme_btn', 'ouvre_btn','tender'].forEach(el => {
        elements[el].classList[action]("ouvert")
    })

    elements.compte.style.visibility = is_open ? "hidden" : "visible";
}

const handleScroll = () => {
    const isScrolled = window.pageYOffset > 50;
    elements.tender.classList.toggle("ouvert", isScrolled);
    elements.compte.style.visibility = isScrolled ? "hidden" : "visible";
};


elements.ouvre_btn.addEventListener('click', toggle_menu(true))
elements.ferme_btn.addEventListener('click', toggle_menu(false))

window.addEventListener('scroll', handleScroll);


window.onscroll = function() {
    if (window.pageYOffset > 50) {
        tender.classList.add("ouvert");
        compte.style.visibility = "hidden"
    } else {
        tender.classList.remove("ouvert");
        compte.style.visibility = "visible"
    }
}
