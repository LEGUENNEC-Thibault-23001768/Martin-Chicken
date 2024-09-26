
const elements  = {
    'ferme_btn': document.getElementById("fermeBtn"),
    'ouvre_btn': document.getElementById("ouvreBtn"),
    'compte': document.getElementById("imgCompte"),
    'tender': document.getElementById("tender"),
    'menu': document.getElementById('menu'),
    'body': document.getElementById('buddy'),
    'pres': document.getElementById('pres')
};


const toggle_menu = (is_open) => {
    const action = is_open ? 'add' : 'remove';
    ['menu', 'ferme_btn', 'ouvre_btn','tender','body'].forEach(el => {
        elements[el].classList[action]("ouvert")
    })

    elements.compte.style.visibility = is_open ? "hidden" : "visible";
}

const handleScroll = () => {
    const isScrolledHeader = window.scrollY > 50;
    const isScrolledTitle = window.scrollY > 150;
    elements.tender.classList.toggle("ouvert", isScrolledHeader);
    elements.pres.classList.toggle("ouvert",isScrolledTitle)
    elements.compte.style.visibility = isScrolledHeader ? "hidden" : "visible";
};

elements.ouvre_btn.addEventListener('click', () => toggle_menu(true));
elements.ferme_btn.addEventListener('click', () => toggle_menu(false));

window.addEventListener('scroll', handleScroll);