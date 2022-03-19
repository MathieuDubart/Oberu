

// ------------------------- function on clic switcher -------------------------
let burger_menu = document.getElementById("burger_menu");
let navbarMobile = document.getElementById("navbarContainerMobile");
let menu_img = document.getElementById("menu_img");

let bool = true;

const deployBurgerMenu = () => {
  if(bool == true){
    navbarMobile.style.display = "block";
    menu_img.src="images/close.svg";
    bool = false;
  }else{
    navbarMobile.style.display = "none";
    menu_img.src="images/burger_menu.svg";
    bool = true;
  }
}

// const closeBurgerMenu = () => { navbarMobile.style.display = "none" }

burger_menu.addEventListener("click", deployBurgerMenu);
// ----------------------------- Form Script's ---------------------------------

let compteur = 0;
$('#add_element').on( "click", function() {
  let mon_nouveau_champs = $("#hidden_field").html()
  mon_nouveau_champs = mon_nouveau_champs.replaceAll('_IDCUSTOM', compteur);
  $( "#container" ).append(mon_nouveau_champs );
  compteur++;
});

let compteur2 = 0;
$('#add_element_instruction').on( "click", function() {
  let mon_nouveau_champs_instr = $("#hidden_field_instruction").html()
  mon_nouveau_champs_instr = mon_nouveau_champs_instr.replaceAll('_IDCUSTOMINSTR', compteur2);
  $( "#container_instruction" ).append(mon_nouveau_champs_instr);
  compteur2++;
});

// let compteur3 = 0
// $('#delete_element0').on( "click", function() {
//   // let mon_nouveau_champs= $("#hidden_field").html()
//   // mon_nouveau_champs = mon_nouveau_champs.replaceAll('_IDCUSTOM', compteur2);
//
//   console.log("in the delete function");
//   $( '#container_select0' ).remove();
//   compteur3++;
// });


//-------------------- SWIPER JS ---------------------

const swiper = new Swiper(".mySwiper", {
  effect: "cards",
  grabCursor: true,
  loop: false,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});
