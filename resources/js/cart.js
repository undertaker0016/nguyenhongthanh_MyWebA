document.addEventListener("submit", function (e) {

    const form = e.target.closest(".form-add-cart");

    if (!form) return;

    e.preventDefault();

    addToCart(form);

});



// Xóa sản phẩm trong giỏ hàng
document.addEventListener("click", function (e) {

    const btn = e.target.closest(".btn-remove-cart");

    if (!btn) return;


    e.preventDefault();


    removeCart(btn);

});





function addToCart(form)
{

    const url = form.action;

    const formData = new FormData(form);



    fetch(url, {

        method:"POST",

        body:formData,

        headers:{
            "Accept":"application/json"
        }

    })


    .then(res=>res.json())


    .then(data=>{


        const cartCount =
            document.getElementById("cart-count");


        if(cartCount)
        {
            cartCount.innerText = data.cartCount;
        }


       


    })


    .catch(err=>{

        console.error(err);

    });

}






function removeCart(btn)
{


    if(!confirm("Bạn có chắc muốn xóa sản phẩm này?"))
    {
        return;
    }



    const url = btn.dataset.url;



    fetch(url, {


        method:"DELETE",


        headers:{


            "Accept":"application/json",


            "X-CSRF-TOKEN":
            document
            .querySelector('meta[name="csrf-token"]')
            .content


        }


    })



    .then(res=>res.json())



    .then(data=>{


        if(!data.status)
        {

            alert(data.message);

            return;

        }



        // xóa dòng sản phẩm
        btn.closest("tr").remove();



        // cập nhật navbar
        const cartCount =
            document.getElementById("cart-count");


        if(cartCount)
        {
            cartCount.innerText = data.cartCount;
        }



        // cập nhật tổng số lượng
        const totalQuantity =
            document.getElementById("totalQuantity");


        if(totalQuantity)
        {
            totalQuantity.innerText =
                data.cartCount;
        }



        // cập nhật tổng tiền
        const total =
            document.getElementById("total");


        if(total)
        {

            total.innerText =
                Number(data.total)
                .toLocaleString("vi-VN")
                + " đ";

        }



        if(data.isEmpty)
        {

            location.reload();

        }



    })



    .catch(err=>{


        console.error(err);

        alert("Có lỗi xảy ra!");

    });



}