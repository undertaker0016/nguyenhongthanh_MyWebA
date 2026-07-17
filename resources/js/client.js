/*
=====================================
 MINI SHOP CLIENT JAVASCRIPT
=====================================
*/


// ================================
// Navbar khi scroll
// ================================

window.addEventListener("scroll", function () {

    const navbar = document.querySelector(".navbar");


    if (window.scrollY > 50) {

        navbar.classList.add("shadow");

    } else {

        navbar.classList.remove("shadow");

    }

});



// ================================
// Thông báo tự ẩn
// ================================

document.addEventListener(
    "DOMContentLoaded",
    function () {


        const alerts = document.querySelectorAll(".alert");


        alerts.forEach(function(alert){


            setTimeout(function(){


                alert.style.transition = "0.5s";

                alert.style.opacity = "0";


                setTimeout(function(){

                    alert.remove();

                },500);


            },3000);



        });


    }
);



// ================================
// Nút thêm giỏ hàng
// ================================


const cartButtons =
document.querySelectorAll(".btn-success");


cartButtons.forEach(function(button){


    button.addEventListener(
        "click",
        function(){


            alert(
                "Đã thêm sản phẩm vào giỏ hàng!"
            );


        }
    );


});



// ================================
// Zoom ảnh sản phẩm
// ================================


const productImages =
document.querySelectorAll(
    ".product-detail img"
);



productImages.forEach(function(img){


    img.style.cursor="zoom-in";


    img.addEventListener(
        "click",
        function(){


            if(img.style.transform === "scale(1.5)"){

                img.style.transform="scale(1)";

            }
            else{

                img.style.transform="scale(1.5)";

            }


            img.style.transition=".3s";


        }
    );


});



// ================================
// Back to top
// ================================


const topButton =
document.createElement("button");


topButton.innerHTML =
"↑";


topButton.className =
"btn btn-primary";


topButton.style.position =
"fixed";


topButton.style.bottom =
"25px";


topButton.style.right =
"25px";


topButton.style.display =
"none";


topButton.style.borderRadius =
"50%";


topButton.style.width =
"45px";


topButton.style.height =
"45px";



document.body.appendChild(topButton);



window.addEventListener(
"scroll",
function(){


    if(window.scrollY > 300){

        topButton.style.display="block";

    }
    else{

        topButton.style.display="none";

    }


});



topButton.addEventListener(
"click",
function(){


    window.scrollTo({

        top:0,

        behavior:"smooth"

    });


});