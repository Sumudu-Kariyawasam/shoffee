function changeView() {
    var signin = document.getElementById("signInBox");
    var signup = document.getElementById("signUpBox");

    signin.classList.toggle("d-none");
    signup.classList.toggle("d-none");
}

function eye_toggle() {
    var pw1 = document.getElementById("pw");
    var pw2 = document.getElementById("pw2");
    var pw3 = document.getElementById("n-pw");
    var pwl = document.getElementById("c-pw");

    if (pw1.type == "password") {
        pw1.type = "text";
    } else {
        pw1.type = "password";
    }
    if (pw2.type == "password") {
        pw2.type = "text";
    } else {
        pw2.type = "password";
    }
    if (pw3.type == "password") {
        pw3.type = "text";
    } else {
        pw3.type = "password";
    }
    if (pwl.type == "password") {
        pwl.type = "text";
    } else {
        pwl.type = "password";
    }
    eye_img();
}

function eye_img() {
    var eye1 = document.getElementById("eye1");
    var eye2 = document.getElementById("eye2");
    var inp1 = document.getElementById("pw2");
    if (inp1.type == "password") {
        eye1.className = "de1 d-block";
        eye2.className = "de2 d-none";
    } else {
        eye1.className = "de1 d-none";
        eye2.className = "de2 d-block";
    }

    var eye3 = document.getElementById("eye3");
    var eye4 = document.getElementById("eye4");
    var inp2 = document.getElementById("pw");
    if (inp2.type == "password") {
        eye3.className = "de3 d-block";
        eye4.className = "de4 d-none";
    } else {
        eye3.className = "de3 d-none";
        eye4.className = "de4 d-block";
    }

    var eye5 = document.getElementById("eye5");
    var eye6 = document.getElementById("eye6");
    var inp3 = document.getElementById("n-pw");
    if (inp3.type == "password") {
        eye5.className = "de5 d-block";
        eye6.className = "de6 d-none";
    } else {
        eye5.className = "de5 d-none";
        eye6.className = "de6 d-block";
    }
}

var vCodeTime = 0;
var newVCodeTime = 0;

function signup() {
    var fn = document.getElementById("fn");
    var ln = document.getElementById("ln");
    var em = document.getElementById("em");
    var pw = document.getElementById("pw");
    var mb = document.getElementById("mb");
    var gd = document.getElementById("gd");
    var tc = document.getElementById("tc");

    var form = new FormData();
    form.append("fn", fn.value);
    form.append("ln", ln.value);
    form.append("em", em.value);
    form.append("pw", pw.value);
    form.append("mb", mb.value);
    form.append("gd", gd.value);
    form.append("tc", tc.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text != "success") {
                document.getElementById("error-text").innerHTML = text;
                document.getElementById("error-box").className = "error-box";
            } else {
                document.getElementById("signInBox").className = "d-none";
                document.getElementById("signUpBox").className = "d-none";
                document.getElementById("verify-Box").className = "row";

                if (vCodeTime == 0) {
                    vCodeTime = setInterval(codeExpireTime, 1000);
                    expire("ex");
                }
            }
        }
    };

    request.open("POST", "signupProcess.php", true);
    request.send(form);
}

function errorClose() {
    document.getElementById("error-box").className = "d-none"
}

function signin() {
    var em = document.getElementById("em2");
    var pw = document.getElementById("pw2");
    var rm = document.getElementById("rm");

    var form = new FormData();

    form.append("em", em.value);
    form.append("pw", pw.value);
    form.append("rm", rm.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text != "success") {
                document.getElementById("error-text").innerHTML = text;
                document.getElementById("error-box").className = "error-box";
            } else {
                window.location = "home.php";
            }
        }
    };

    request.open("POST", "signinProcess.php", true);
    request.send(form);
}

var email = document.getElementById("em");
var code = document.getElementById("v-code");

function verifyEmail() {

    var form = new FormData();
    form.append("em", email.value);
    form.append("vc", code.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("suc-txt").innerHTML = "Email Verified";
                document.getElementById("suc_box").className = "col-8 col-md-6 col-lg-4 offset-lg-4 suc-box flex-column gap-3";
                setTimeout(() => {
                    window.location = "home.php";
                }, 2000);
            } else {
                document.getElementById("error-text").innerHTML = text;
                document.getElementById("error-box").className = "error-box";
            }
        }
    };

    request.open("POST", "emailVerify.php", true);
    request.send(form);
}

var seconds = 60;
var stopin = 0;
var rsstart = "0";

function codeExpireTime() {
    document.getElementById("countdown").className = "d-block";
    rsstart = "1";
    seconds = seconds - 1;
    stopin = stopin + 1
    document.getElementById("countdown").innerHTML = "0:" + seconds;
    if (seconds < 10) {
        document.getElementById("countdown").innerHTML = "0:0" + seconds;
    }
    if (stopin == 60) {
        codeExp();
        vCodeTime = 0;
    }
    setTimeout(rsset, 60000);
}

function rsset() {
    rsstart = "2";
}

function codeExp() {
    clearInterval(vCodeTime);
    clearInterval(codeExpire);

}

var newSeconds = 60;
var newStopin = 0;
var resettime = "0";

function resend_vc() {
    if (rsstart == "2") {
        if (resettime == "0") {
            newVCodeTime = setInterval(newCodeExpireTime, 1000);
            document.getElementById("countdown").className = "d-none";
            document.getElementById("countdown2").className = "d-block";
            resettime = "1";

            var request = new XMLHttpRequest();

            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    var text = request.responseText;
                    alert(text);
                }
            };

            request.open("GET", "resendSIgnupVCode.php?em=" + email.value, true);
            request.send();
            expire();
        }
    }
}

function newCodeExpireTime() {
    newSeconds = newSeconds - 1;
    newStopin = newStopin + 1
    document.getElementById("countdown2").innerHTML = "0:" + newSeconds;
    if (newSeconds < 10) {
        document.getElementById("countdown2").innerHTML = "0:0" + newSeconds;
    }
    if (newStopin == 60) {
        newCodeExp();
    }
}

function newCodeExp() {
    clearInterval(newVCodeTime);
    newSeconds = 60;
    newStopin = 0;
    resettime = "0";
}

function expire(ex) {
    var form = new FormData();
    form.append("em", email.value);
    form.append("ex", ex);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            // alert(text);
        }
    }

    request.open("POST", "expire.php", true);
    request.send(form);
}

// gorget password box

var fogSeconds = 60;
var fogStopin = 0;
var fogVcExpire = 0;

function fog_open() {

    if (fogVcExpire == 0) {

        var em = document.getElementById("em2");

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                var text = request.responseText;
                if (text == "success") {
                    document.getElementById("fog-box").className = "col-10 col-lg-5 offset-1 fog-box d-block";
                    fogVcExpire = setInterval(countFogVc, 1000);
                    fogReset();
                } else {
                    document.getElementById("error-text").innerHTML = text;
                    document.getElementById("error-box").className = "error-box";
                }
            }
        };

        request.open("GET", "forgetPassword.php?em=" + em.value, true);
        request.send();
    }
}

function countFogVc() {
    fogSeconds = fogSeconds - 1;
    fogStopin = fogStopin + 1
    document.getElementById("countdown3").innerHTML = "0:" + fogSeconds;
    if (fogSeconds < 10) {
        document.getElementById("countdown3").innerHTML = "0:0" + fogSeconds;
    }
    if (fogStopin == 60) {
        fogCodeExp();
    }
}

function fogCodeExp() {
    clearInterval(fogVcExpire);
    fogSeconds = 60;
    fogStopin = 0;
    fogVcExpire = 0;
}

function fog_close() {
    document.getElementById("fog-box").className = "d-none";
    document.getElementById("suc_box").className = "d-none";
}

function fogReset() {
    var email = document.getElementById("em2");

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            // alert (text);
        }
    };

    request.open("GET", "fogExpire.php?em=" + email.value, true);
    request.send();
}

// reset password

function resetPassword() {
    var email = document.getElementById("em2");
    var code = document.getElementById("v-code2");
    var n_pw = document.getElementById("n-pw");
    var c_pw = document.getElementById("c-pw");

    var form = new FormData();
    form.append("em", email.value);
    form.append("code", code.value);
    form.append("npw", n_pw.value);
    form.append("cpw", c_pw.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("suc-txt").innerHTML = "Password Changed";
                document.getElementById("suc_box").className = "col-8 col-md-6 col-lg-4 offset-lg-4 suc-box flex-column gap-3";
                setTimeout(() => {
                    window.location = "home.php";
                }, 2000);
            } else {
                // document.getElementById("error-text").innerHTML = text;
                // document.getElementById("error-box").className = "error-box";
                alert(text);
            }
        }
    };

    request.open("POST", "resetPassword.php", true);
    request.send(form);
}

function selectCity() {
    var dist = document.getElementById("dt").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("ct").innerHTML = '<option value="0">Select City</option>' + text;
        }
    };

    r.open("GET", "selectCityProcess.php?d=" + dist, true);
    r.send();

}

function logout() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = this.responseText;
            if (t == "success") {
                window.location = "home.php";
            } else {
                alert("Something went wrong!");
            }
        }
    };

    r.open("GET", "logoutProcess.php", true);
    r.send();
}

function viewProImg() {
    var img = document.getElementById("proimgbtn");
    var view = document.getElementById("proImgView");

    img.onchange = function () {
        var file = this.files["0"];
        var url = window.URL.createObjectURL(file);
        view.src = url;
    }
}

function updateProfile() {
    var fname = document.getElementById("fn").value;
    var lname = document.getElementById("ln").value;
    var mobile = document.getElementById("mb").value;
    var office = document.getElementById("of").value;
    var no = document.getElementById("no").value;
    var line1 = document.getElementById("l1").value;
    var line2 = document.getElementById("l2").value;
    var district = document.getElementById("dt").value;
    var city = document.getElementById("ct").value;
    var postal = document.getElementById("pc").value;
    var img = document.getElementById("proimgbtn");

    var f = new FormData();
    f.append("fn", fname);
    f.append("ln", lname);
    f.append("mb", mobile);
    f.append("of", office);
    f.append("no", no);
    f.append("l1", line1);
    f.append("l2", line2);
    f.append("dt", district);
    f.append("ct", city);
    f.append("pc", postal);

    if (img.length == 0) {
        var conf = confirm("You have not selected profile image. Continue?");
        if (conf) {
            alert("You have not seleted profile image");
        }
    } else {
        f.append("img", img.files["0"]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };
    r.open("POST", "updateProfile.php", true);
    r.send(f);
}

function addtowish(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Product added to wishlist");
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "addtoWishlistProcess.php?id=" + id, true);
    r.send();
}

function addtoCart(id) {
    var qty = document.getElementById("p-qty").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    };

    r.open("GET", "addtoCartProcess.php?id=" + id + "&qt=" + qty, true);
    r.send();
}

function wishOnetoCart(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "addOnetoCartProcess.php?id=" + id, true);
    r.send();
}

function priceCal(price, id, num) {
    // var qty = document.getElementById("p-qty-c").value;
    var arr = document.getElementById("arr").value;
    var array = JSON.parse(arr)
    // var total = document.getElementById("pprice"+id);
    // var sub1 = parseInt(total.value);

    // var pro_total = (price * qty);
    // var tt = (sub1 + pro_total);

    // total.innerHTML = "LKR. "+pro_total+" .00";
    alert(array["0"]["id"]);
}

function selectCateHome(gid) {
    if (gid = 0) {
        var cate = "0";
    } else {
        cate = document.getElementById("cat_sele").value;
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("shopview").innerHTML = t;
        }
    };

    r.open("GET", "ShopProcess.php?id=" + cate, true);
    r.send();
}

function deleteProduct(pid) {
    var confirmation = confirm("Do you want to delete this Product?");

    if (confirmation) {

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;
                if (t == "success") {
                    alert("Product Successfully Deleted");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("GET", "deleteProduct.php?id=" + pid, true);
        r.send();
    }
}

function loadPimages() {
    var images = document.getElementById("ii");

    images.onchange = function () {
        var image_count = images.files.length;

        if (image_count <= 6) {
            for (var x = 0; x < image_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("view" + x).src = url;
            }
        } else {
            alert("Maximum Only 6 images");
        }
    }
}

function addProduct() {
    var cate = document.getElementById("a_ct").value;
    var sub_cate = document.getElementById("a_sct").value;
    var brand = document.getElementById("a_br").value;
    var model = document.getElementById("a_md").value;
    var title = document.getElementById("a_tt").value;
    var condi;
    if (document.getElementById("a_cn1").checked == 1) {
        condi = 1;
    } else if (document.getElementById("a_cn2").checked == 2) {
        condi = 2;
    }
    var color = document.getElementById("a_cl").value;
    var qty = document.getElementById("a_qt").value;
    var price = document.getElementById("a_pr").value;
    var dilc = document.getElementById("a_dc").value;
    var dilo = document.getElementById("a_do").value;
    var desc = document.getElementById("a_ds").value;
    var sdec = document.getElementById("a_sd").value;
    var image = document.getElementById("ii");

    var f = new FormData();

    f.append("ct", cate);
    f.append("sc", sub_cate);
    f.append("br", brand);
    f.append("md", model);
    f.append("tt", title);
    f.append("cn", condi);
    f.append("cl", color);
    f.append("qt", qty);
    f.append("pr", price);
    f.append("dc", dilc);
    f.append("do", dilo);
    f.append("de", desc);
    f.append("sd", sdec);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("product Listed");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

    // alert(sub_cate);

}

function updateProduct(id) {
    var cate = document.getElementById("a_ct").value;
    var sub_cate = document.getElementById("a_sct").value;
    var brand = document.getElementById("a_br").value;
    var model = document.getElementById("a_md").value;
    var title = document.getElementById("u_tt").value;
    var condi;
    if (document.getElementById("a_cn1").checked) {
        condi = 1;
    } else if (document.getElementById("a_cn2").checked) {
        condi = 2;
    }
    var color = document.getElementById("u_cl").value;
    var price = document.getElementById("u_pr").value;
    var dilc = document.getElementById("u_dc").value;
    var dilo = document.getElementById("u_do").value;
    var desc = document.getElementById("u_ds").value;
    var sdec = document.getElementById("u_sd").value;
    var image = document.getElementById("ii");

    var f = new FormData();

    f.append("id", id);
    f.append("ct", cate);
    f.append("sc", sub_cate);
    f.append("br", brand);
    f.append("md", model);
    f.append("tt", title);
    f.append("cn", condi);
    f.append("cl", color);
    f.append("pr", price);
    f.append("dc", dilc);
    f.append("do", dilo);
    f.append("de", desc);
    f.append("sd", sdec);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("product Updated");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "updateProductProcess.php", true);
    r.send(f);
}

function singleProduct(id) {
    window.location = "singleProduct.php?id=" + id;
}

function removewish(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Removed from wishlist");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "removeFromWishlistProcess.php?id=" + id, true);
    r.send();
}

function removecart(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Removed from cart");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "removeFromCartProcess.php?id=" + id, true);
    r.send();
}

function toproduct(id) {
    window.location = 'singleProduct.php?id=' + id;
}

function directCheckout(id) {
    var qty = document.getElementById("p-qty").value;
    window.location = "directCheckout.php?id=" + id + "&qty=" + qty;
}

function payNow() {

    var id = document.getElementById("ids").value;
    var qty = document.getElementById("qtys").value;
    var c_box = document.getElementById("add-use").checked;
    var no = document.getElementById("c-no").value;
    var line1 = document.getElementById("c-l1").value;
    var line2 = document.getElementById("c-l2").value;
    var city = document.getElementById("ct").value;
    var district = document.getElementById("dt").value;
    var postal = document.getElementById("c-pc").value;

    var f = new FormData();
    f.append("id", id);
    f.append("qty", qty);
    f.append("no", no);
    f.append("l1", line1);
    f.append("l2", line2);
    f.append("ct", city);
    f.append("dt", district);
    f.append("pc", postal);
    f.append("cb", c_box);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            var data = JSON.parse(t);
            if (data["error"] != null) {
                alert(data["error"]);
            } else {
                getInform(t);
            }
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                // Note: validate the payment and show success or failure page to the customer


            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                // Note: Prompt user to pay again or show an error page
                console.log("Payment dismissed");
            };

            // Error occurred
            payhere.onError = function onError(error) {
                // Note: show an error page
                console.log("Error:" + error);
            };

            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "1221474",    // Replace your Merchant ID
                "return_url": undefined,     // Important
                "cancel_url": undefined,     // Important
                "notify_url": "",
                "order_id": data["order_id"],
                "items": data["order_id"] + " - " + data["items"] + "items",
                "amount": data["total"],
                "currency": "LKR",
                "first_name": data["fname"],
                "last_name": data["lname"],
                "email": data["email"],
                "phone": data["mobile"],
                "address": data["address"],
                "city": data["city"],
                "country": "Sri Lanka",
                "delivery_address": data["address"],
                "delivery_city": data["city"],
                "delivery_country": "Sri Lanka",
                "custom_1": "",
                "custom_2": ""
            };

            // Show the payhere.js popup, when "PayHere Pay" is clicked
            document.getElementById('payhere-payment').onclick = function (e) {
                payhere.startPayment(payment);
            };
        }
    };

    r.open("POST", "purchasingProcess.php", true);
    r.send(f);
}

function getInform(txt) {
    var data = JSON.parse(txt);

    var f = new FormData();
    f.append("order_id", data["order_id"]);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    }
    r.open("POST", "payprocess.php", true);
    r.send(f);
}

function setAddress() {
    var c_box = document.getElementById("add-use");
    var line1 = document.getElementById("c-l1");
    var line2 = document.getElementById("c-l2");
    var city = document.getElementById("ct");
    var district = document.getElementById("dt");
    var postal = document.getElementById("c-pc");

    if (c_box.checked) {
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;
                var data = JSON.parse(t);

                line1.value = data["line1"];
                line2.value = data["line2"];
                district.innerHTML = "<option value=" + data["district_id"] + ">" + data["district"] + "</option>";
                city.innerHTML = "<option value=" + data["city_id"] + ">" + data["city"] + "</option>";
                postal.value = data["postal"];
            }
        };

        r.open("GET", "checkoutAddressProcess.php", true);
        r.send();
    } else {
        window.location.reload();
        
    }
}

function seleted_sub(sub) {
    var c = document.getElementById("a_ct").value;
    var f = new FormData();
    f.append("c", c);
    f.append("s", sub);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("a_sct").innerHTML = t;
        }
    };

    r.open("POST", "selectSubCategoryProcess.php", true);
    r.send(f);
}

function seleted_brand(bnd) {
    var s = document.getElementById("a_sct").value;
    var f = new FormData();
    f.append("s", s);
    f.append("b", bnd);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("a_br").innerHTML = t;
        }
    };

    r.open("POST", "selectBrandProcess.php", true);
    r.send(f);

    // alert("OK");
}

function seleted_model(mdl) {
    var br = document.getElementById("a_br").value;
    var s = document.getElementById("a_sct").value;
    var f = new FormData();
    f.append("s", s);
    f.append("b", br);
    f.append("m", mdl);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("a_md").innerHTML = t;
            // alert(t);
        }
    };

    r.open("POST", "selectModelProcess.php", true);
    r.send(f);
}

function advancedSearch(page) {
    var title = document.getElementById("ad_tt").value;
    var price_f = document.getElementById("ad_pf").value;
    var price_t = document.getElementById("ad_pt").value;
    var cate = document.getElementById("cat_sele").value;
    var sub = document.getElementById("ssub").value;
    var brand = document.getElementById("sbrd").value;
    var model = document.getElementById("smdl").value;
    var cond = document.getElementById("scon").value;

    var f = new FormData();
    f.append("tt", title);
    f.append("pf", price_f);
    f.append("pt", price_t);
    f.append("ct", cate);
    f.append("sc", sub);
    f.append("br", brand);
    f.append("md", model);
    f.append("cn", cond);
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("shopview").innerHTML = t;
            // alert(t);
        }
    };

    r.open("POST", "advancedProcess.php", true);
    r.send(f);

}

function changeStatus(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                document.getElementById("status_p" + id).innerHTML = "Activated";
                document.getElementById("status_a" + id).innerHTML = "Active";
                document.getElementById("status_p" + id).classList = "form-check-label t-suc";
                document.getElementById("status_a" + id).classList = "t-suc";
            } else if (t == 2) {
                document.getElementById("status_p" + id).innerHTML = "Deactivated";
                document.getElementById("status_a" + id).innerHTML = "Deactive";
                document.getElementById("status_p" + id).classList = "form-check-label t-dng";
                document.getElementById("status_a" + id).classList = "t-dng";
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "changeStatusProcess.php?id=" + id, true);
    r.send();
}

function mainImg(x) {
    var path = document.getElementById("img_view" + x).src;

    var main = document.getElementById("main_img");
    main.src = path;
}

function ViewMainImg() {
    document.getElementById("mainimg-box").classList = "main-img-box";
    var path = document.getElementById("main_img").src;

    var main = document.getElementById("main_img_view");
    main.src = path;
    // alert("OK");
}

function closeMainImg() {
    document.getElementById("mainimg-box").classList = "d-none";
}

function deleteInvoice(y) {
    var id;
    if (y != null) {
        id = document.getElementById("ino_id" + y).innerHTML;
    } else {
        id = document.getElementById("invo_id").value;
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "purchasehistory.php";
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "deleteInvoiceProcess.php?id=" + id, true);
    r.send();
}

function deleteall() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "purchasehistory.php";
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "deleteAllInvoiceProcess.php", true);
    r.send();
}

function historySort(page) {
    var txt = document.getElementById("ph_oi").value;
    var date1 = document.getElementById("date1").value;
    var date2 = document.getElementById("date2").value;
    var time1 = document.getElementById("time1");
    var time2 = document.getElementById("time2");
    var time;
    if (time1.checked) {
        time = 1;
    } else if (time2.checked) {
        time = 2;
    }

    var f = new FormData();
    f.append("txt", txt);
    f.append("date1", date1);
    f.append("date2", date2);
    f.append("time", time);
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            // alert(t);
            document.getElementById("p_history").innerHTML = t;
        }
    };

    r.open("POST", "purchasingHistorySortProcess.php", true);
    r.send(f);
}

function historySort1(page) {
    var txt = document.getElementById("ph_oi").value;
    var date1 = document.getElementById("1date1").value;
    var date2 = document.getElementById("1date2").value;
    var time1 = document.getElementById("1time1");
    var time2 = document.getElementById("1time2");
    var time;
    if (time1.checked) {
        time = 1;
    } else if (time2.checked) {
        time = 2;
    }

    var f = new FormData();
    f.append("txt", txt);
    f.append("date1", date1);
    f.append("date2", date2);
    f.append("time", time);
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            // alert(t);
            document.getElementById("p_history").innerHTML = t;
        }
    };

    r.open("POST", "purchasingHistorySortProcess.php", true);
    r.send(f);
}

var feedback;
var feedback_product_id;
function Feedback(id) {
    var fm = document.getElementById("feedback");
    var feedback = new bootstrap.Modal(fm);
    feedback_product_id = id;
    feedback.show();
}

var star_rate = 5;
function starShow(y) {
    var star1 = document.getElementById("star-f0");
    var star2 = document.getElementById("star-f1");
    var star3 = document.getElementById("star-f2");
    var star4 = document.getElementById("star-f3");
    var star5 = document.getElementById("star-f4");

    var star_fill = "icon-svg/star-fill.svg";
    var star = "icon-svg/star.svg";

    if (y == 0) {
        star1.src = star_fill;
        star2.src = star;
        star3.src = star;
        star4.src = star;
        star5.src = star;
        star_rate = 1;
    } else if (y == 1) {
        star1.src = star_fill;
        star2.src = star_fill;
        star3.src = star;
        star4.src = star;
        star5.src = star;
        star_rate = 2;
    } else if (y == 2) {
        star1.src = star_fill;
        star2.src = star_fill;
        star3.src = star_fill;
        star4.src = star;
        star5.src = star;
        star_rate = 3;
    } else if (y == 3) {
        star1.src = star_fill;
        star2.src = star_fill;
        star3.src = star_fill;
        star4.src = star_fill;
        star5.src = star;

        star_rate = 4;
    } else if (y == 4) {
        star1.src = star_fill;
        star2.src = star_fill;
        star3.src = star_fill;
        star4.src = star_fill;
        star5.src = star_fill;
        star_rate = 5;
    }
}

function sendFeedback() {
    var face1 = document.getElementById("f-po");
    var face2 = document.getElementById("f-nu");
    var face3 = document.getElementById("f-ne");
    var comment = document.getElementById("comm").value;

    var face;
    if (face1.checked) {
        face = 1;
    } else if (face2.checked) {
        face = 2;
    } else if (face3.checked) {
        face = 3;
    }

    var f = new FormData();
    f.append("face", face);
    f.append("star", star_rate);
    f.append("comm", comment);
    f.append("id", feedback_product_id);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Feedback Sent Successfuly");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "sendFeedbackProcess.php", true);
    r.send(f);

}

function updateOrderStatus(pid) {
    var oid = document.getElementById("order_id").value;
    var status;
    if (pid == "no") {
        status = document.getElementById("o_status2").value;
    } else {
        status = document.getElementById("o_status").value;
    }

    var f = new FormData();
    f.append("oid", oid);
    f.append("pid", pid);
    f.append("sts", status);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Order Status Updated");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "updateOrderStatusProcess.php", true);
    r.send(f);

    // alert(status);
}

function orderSort(page) {
    var txt = document.getElementById("o_txt").value;
    var nto = document.getElementById("o_time1");
    var otn = document.getElementById("o_time2");
    var pend = document.getElementById("o_status1");
    var ready = document.getElementById("o_status2");
    var sent = document.getElementById("o_status3");
    var date_f = document.getElementById("o_date1").value;
    var date_t = document.getElementById("o_date2").value;

    var time;
    if (nto.checked) {
        time = 1;
    } else if (otn.checked) {
        time = 2;
    }

    var status;
    if (pend.checked) {
        status = 1;
    } else if (ready.checked) {
        status = 2;
    } else if (sent.checked) {
        status = 3;
    }

    var f = new FormData();
    f.append("txt", txt);
    f.append("time", time);
    f.append("sts", status);
    f.append("df", date_f);
    f.append("dt", date_t);
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("order_sorted").innerHTML = t;
        }
    };

    r.open("POST", "orderSortProcess.php", true);
    r.send(f);
}

function sortListings() {
    var txt = document.getElementById("ml_txt").value;
    var nto = document.getElementById("ml_time1");
    var otn = document.getElementById("ml_time2");
    var htl = document.getElementById("ml_qty1");
    var lth = document.getElementById("ml_qty2");
    var b_new = document.getElementById("ml_con1");
    var used = document.getElementById("ml_con2");

    var time;
    var qty;
    var use;

    if (nto.checked) {
        time = 1;
    } else if (otn.checked) {
        time = 2;
    }

    if (htl.checked) {
        qty = 1;
    } else if (lth.checked) {
        qty = 2;
    }

    if (b_new.checked) {
        use = 1;
    } else if (used.checked) {
        use = 2;
    }

    var f = new FormData();
    f.append("txt", txt);
    f.append("time", time);
    f.append("qty", qty);
    f.append("use", use);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("listing_sorted").innerHTML = t;
            // alert(t);
        }
    };

    r.open("POST", "myListingSortProcess.php", true);
    r.send(f);
}

function chatChange(tab) {
    var rece = document.getElementById("received_msg");
    var sent = document.getElementById("sent_msg");
    var nav_r = document.getElementById("nav1");
    var nav_s = document.getElementById("nav2");

    if (tab == "r") {
        rece.classList = "row p-2";
        sent.classList = "row p-2 d-none";
        nav_r.classList = "nav-link active";
        nav_s.classList = "nav-link";
    } else if (tab == "s") {
        rece.classList = "row p-2 d-none";
        sent.classList = "row p-2";
        nav_r.classList = "nav-link";
        nav_s.classList = "nav-link active";
    }
}

var email;
var cus_name;
function viewMsg(x) {
    var width = innerWidth;
    if (width < 992) {
        document.getElementById("all_chat").classList = "d-none";
        document.getElementById("selected_chat").classList = "ms-0 ms-lg-5 col-12 col-lg-7 border border-secondary border-opacity-50 rounded";
    }
    email = document.getElementById("sender_em" + x).value;
    var uname = document.getElementById("msg_name" + x).innerHTML;
    document.getElementById("msg_name_view").innerHTML = uname;
    document.getElementById("msg_email_view").innerHTML = email;
    document.getElementById("msg_email_view").classList = "d-block";
    cus_name = uname;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("chat_view").innerHTML = t;
        }
    };

    r.open("GET", "viewMsgProcess.php?em=" + email, true);
    r.send();
}

function send_msg() {
    var txt = document.getElementById("msg_txt").value;
    if (email != null) {
        var f = new FormData();
        f.append("em", email);
        f.append("txt", txt);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;
                if (t == "success") {
                    viewMsg2();
                } else {
                    alert(t);
                }
            }
        };

        r.open("POST", "sendMsgProcess.php", true);
        r.send(f);

    }
}

function viewMsg2(x) {
    document.getElementById("msg_name_view").innerHTML = cus_name;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("chat_view").innerHTML = t;
            document.getElementById("msg_txt").value = "";
        }
    };

    r.open("GET", "viewMsgProcess.php?em=" + email + "&re=no", true);
    r.send();
}

function backToMsg() {
    document.getElementById("selected_chat").classList = "d-none";
}

var nmsg;
function newMsg() {
    var nm = document.getElementById("new-msg");
    var msg = new bootstrap.Modal(nm);
    msg.show();
}

function send_new_msg(dir) {
    var rmail;
    var ntxt;
    if (dir == "direct") {
        rmail = document.getElementById("direct_email").innerHTML;
        ntxt = document.getElementById("dir_msg_txt").value;
    } else {
        rmail = document.getElementById("new_msg_em").value;
        ntxt = document.getElementById("new_msg_txt").value;
    }

    var f = new FormData();
    f.append("rem", rmail);
    f.append("txt", ntxt);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "newMsgProcess.php", true);
    r.send(f);

}

var pnm;
function contactSeller() {
    var nmp = document.getElementById("new-msg_product");
    var pnm = new bootstrap.Modal(nmp);
    pnm.show();
}

function adminSigninVerify() {
    var aemail = document.getElementById("adm_em").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Verification code sent to your Email");
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "adminVerificationSendProcess.php?ae=" + aemail, true);
    r.send();
}

// ------------------ Admin panel scripts --------------------- //

function adminSignin() {
    var aemail = document.getElementById("adm_em").value;
    var acode = document.getElementById("adm_vc").value;
    var apass = document.getElementById("adm_pw").value;

    var f = new FormData();
    f.append("em", aemail);
    f.append("vc", acode);
    f.append("ap", apass);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "adminpanel.php";
            } else {
                alert(t);
            }
            adminExpire();
        }
    };

    r.open("POST", "adminSigninProcess.php", true);
    r.send(f);
}

function adminExpire() {
    var aemail = document.getElementById("adm_em").value;

    var ex = "ax";

    var form = new FormData();
    form.append("em", aemail);
    form.append("ex", ex);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            // alert(text);
        }
    }

    request.open("POST", "expire.php", true);
    request.send(form);
}

function showNavMenu() {
    // document.getElementById("nav_menu_box").style.marginLeft = "0";
    var nav = document.getElementById("nav_menu_box");
    nav.classList.toggle("nav_close");
}

function closeNavMenu() {
    var nav = document.getElementById("nav_menu_box");
    nav.classList.toggle("nav_close");
}

var get;
function AdminProdChange(tab) {
    var all_tab = document.getElementById("tab1");
    var act_tab = document.getElementById("tab2");
    var pen_tab = document.getElementById("tab3");
    var dlt_tab = document.getElementById("tab4");

    if (tab == "all") {
        all_tab.classList = "nav-link active";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminAllProducts('1','all');
        get = "all";
    } else if (tab == "act") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link active";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminAllProducts('1','act');
        get = "act";
    } else if (tab == "dct") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link active";
        dlt_tab.classList = "nav-link nav2";
        adminAllProducts('1','dct');
        get = "dct";
    } else if (tab == "dlt") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link active";
        adminAllProducts('1','dlt');
        get = "dlt";
    }
}

function adminAllProducts(page,type) {
    var sub_cate = document.getElementById("adm_all_sbc");
    var brand = document.getElementById("adm_all_brd");
    var model = document.getElementById("adm_all_mdl");
    var condi = document.getElementById("adm_all_con");
    var price_f = document.getElementById("adm_all_prf");
    var price_t = document.getElementById("adm_all_prt");
    var text = document.getElementById("adm_all_txt");
    var time = document.getElementById("ad_sort_time");
    var status = 0;

    var f = new FormData();
    f.append("sc", sub_cate.value);
    f.append("br", brand.value);
    f.append("md", model.value);
    f.append("cn", condi.value);
    f.append("pf", price_f.value);
    f.append("pt", price_t.value);
    f.append("tt", text.value);
    f.append("tm", time.value);
    f.append("status", status);
    f.append("page",page);
    if(type == "get"){
        if(get == null){
            f.append("type","all");
        }else{
            f.append("type",get);
        }
    }else{
        f.append("type",type);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("ad_all_pro_view").innerHTML = t;
        }
    }

    r.open("POST", "adminAllProductLoadProcess.php", true);
    r.send(f);
}

var get2;
function AdminUSerChange(tab) {
    var all_tab = document.getElementById("tabU1");
    var act_tab = document.getElementById("tabU2");
    var pen_tab = document.getElementById("tabU3");
    var dlt_tab = document.getElementById("tabU4");

    if (tab == "all") {
        all_tab.classList = "nav-link active";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminAllUsers('1','all');
        get2 = "all";
    } else if (tab == "act") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link active";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminAllUsers('1','act');
        get2 = "act";
    } else if (tab == "dct") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link active";
        dlt_tab.classList = "nav-link nav2";
        adminAllUsers('1','dct');
        get2 = "dct";
    } else if (tab == "dlt") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link active";
        adminAllUsers('1','dlt');
        get2 = "dlt";
    }
}

function adminAllUsers(page,type) {
    var email = document.getElementById("adm_usr_em");
    var fname = document.getElementById("adm_usr_fn");
    var lname = document.getElementById("adm_usr_ln");
    var date_f = document.getElementById("adm_usr_df");
    var date_t = document.getElementById("adm_usr_dt");
    var time = document.getElementById("adu_sort_time");
    var status = 0;

    var f = new FormData();
    f.append("em", email.value);
    f.append("fn", fname.value);
    f.append("ln", lname.value);
    f.append("df", date_f.value);
    f.append("dt", date_t.value);
    f.append("tm", time.value);

    f.append("status", status);
    f.append("page",page);
    if(type == "get"){
        if(get2 == null){
            f.append("type","all");
        }else{
            f.append("type",get2);
        }
    }else{
        f.append("type",type);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("ad_all_usr_view").innerHTML = t;
        }
    }

    r.open("POST", "adminAllUsersLoadProcess.php", true);
    r.send(f);
}


function changeStatusAdm(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                document.getElementById("status_p" + id).innerHTML = "Make this product Dectivated";
                document.getElementById("status_a" + id).innerHTML = "Active";
                document.getElementById("status_p" + id).classList = "form-check-label t-dng";
                document.getElementById("status_a" + id).classList = "t-suc";
            } else if (t == 2) {
                document.getElementById("status_p" + id).innerHTML = "Make this product Activated";
                document.getElementById("status_a" + id).innerHTML = "Deactive";
                document.getElementById("status_p" + id).classList = "form-check-label t-suc";
                document.getElementById("status_a" + id).classList = "text-warning";
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "changeStatusProcess.php?id=" + id, true);
    r.send();
}


function AdminOtherChange(tab) {
    var category = document.getElementById("ad_cat_view");
    var sub_cate = document.getElementById("ad_sub_view");
    var brand = document.getElementById("ad_brd_view");
    var model = document.getElementById("ad_mdl_view");

    if (tab == "cat") {
        category.classList = "nav-link active";
        sub_cate.classList = "nav-link nav2";
        brand.classList = "nav-link nav2";
        model.classList = "nav-link nav2";
        loadOtherManages("cat");

    } else if (tab == "sub") {
        category.classList = "nav-link nav2";
        sub_cate.classList = "nav-link active";
        brand.classList = "nav-link nav2";
        model.classList = "nav-link nav2";
        loadOtherManages("sub");

    } else if (tab == "brd") {
        category.classList = "nav-link nav2";
        sub_cate.classList = "nav-link nav2";
        brand.classList = "nav-link active";
        model.classList = "nav-link nav2";
        loadOtherManages("brd");

    } else if (tab == "mdl") {
        category.classList = "nav-link nav2";
        sub_cate.classList = "nav-link nav2";
        brand.classList = "nav-link nav2";
        model.classList = "nav-link active";
        loadOtherManages("mdl");
    }
}

function loadOtherManages(view){

    var f = new FormData();
    f.append("view",view);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("ad_other_view").innerHTML = t;
        }
    }

    r.open("POST", "adminOthersLoadProcess.php", true);
    r.send(f);
}

var addcm;
function addNewCategory(){
    addcm = document.getElementById("add_cate_adm");
    var add_cat = new bootstrap.Modal(addcm);
    add_cat.show();
}

var addsb;
function addNewSubCategory(){
    addsb = document.getElementById("add_sub_adm");
    var add_sub = new bootstrap.Modal(addsb);
    add_sub.show();
}

var addbr;
function addNewBrand(){
    addbr = document.getElementById("add_brd_adm");
    var add_brd = new bootstrap.Modal(addbr);
    add_brd.show();
}

var addmd;
function addNewModel(){
    addmd = document.getElementById("add_mdl_adm");
    var add_mdl = new bootstrap.Modal(addmd);
    add_mdl.show();
}

function admSaveCategory(){
    var category = document.getElementById("ad_cat_name").value;
    var password = document.getElementById("ad_cat_pw").value;
    var f = new FormData();
    f.append("cg",category);
    f.append("pw",password);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == "success") {
                alert("Category added successfully");
                loadOtherManages("cat");
                category.value = null;
                password.value = null;
            }else{
                alert(t);
            }
        }
    }

    r.open("POST", "adminAddCategoryProcess.php", true);
    r.send(f);
}

function admSaveSubCategory(){
    var sub_cate= document.getElementById("ad_sub_name").value;
    var category = document.getElementById("ad_sltd_cat").value;
    var password = document.getElementById("ad_sub_pw").value;
    var f = new FormData();
    f.append("sb",sub_cate);
    f.append("cg",category);
    f.append("pw",password);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == "success") {
                alert("Sub Category added successfully");
                loadOtherManages("sub");
                sub_cate.value = 0;
                category.value = null;
                password.value = null;
            }else{
                alert(t);
            }
        }
    }

    r.open("POST", "adminAddSubCategoryProcess.php", true);
    r.send(f);
}

function admSaveBrand(){
    var brand = document.getElementById("ad_brd_name").value;
    var sub_cate = document.getElementById("ad_sltd_bsub").value;
    var password = document.getElementById("ad_brd_pw").value;
    var f = new FormData();
    f.append("br",brand);
    f.append("sc",sub_cate);
    f.append("pw",password);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == "success") {
                alert("Brand added successfully");
                loadOtherManages("brd");
                brand.value = null;
                password.value = null;
            }else{
                alert(t);
            }
        }
    }

    r.open("POST", "adminAddBrandsProcess.php", true);
    r.send(f);
}

function admSaveModel(){
    var model= document.getElementById("ad_mdl_name").value;
    var brand= document.getElementById("ad_sltd_brd").value;
    var sub_cate = document.getElementById("ad_sltd_sub").value;
    var password = document.getElementById("ad_mdl_pw").value;
    var f = new FormData();
    f.append("md",model);
    f.append("br",brand);
    f.append("sc",sub_cate);
    f.append("pw",password);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == "success") {
                alert("Model added successfully");
                loadOtherManages("mdl");
                sub_cate.value = 0;
                brand.value = 0;
                model.value = null;
                password.value = null;
            }else{
                alert(t);
            }
        }
    }

    r.open("POST", "adminAddModelProcess.php", true);
    r.send(f);
}

function admDeleteCategory(id){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == 0) {
                confirmDeleteCategory(id);
            }else{
                alert("This category has "+ t +" Sub Categories. If you want to delete this category, You have to manually delete that Sub Categories first.");
            }
        }
    }

    r.open("GET", "adminDeleteCategoryProcess.php?id=" + id, true);
    r.send();
}

function confirmDeleteCategory(id){
    var confirmation = confirm("This action will be deleted all the sub categories of this category! Do you want to continue?");

    if(confirmation){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = JSON.parse(r.responseText);
                if(t["cats"] == "success") {
                    alert("Category deleted successfully with "+t["subs"]+" sub categories");
                    loadOtherManages("cat");
                }else{
                    alert(t);
                }
            }
        }
    }

    r.open("GET", "confirmedDeleteCategoryProcess.php?id=" + id, true);
    r.send(); 
}

function admDeleteSubCategory(id){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == 0) {
                confirmDeleteSubcategory(id);
            }else{
                alert("There are "+t+" products listed with this Sub Category. If you want to delete this Sub Category, You have to manually delete that Products first.");
            }
        }
    }

    r.open("GET", "adminDeleteSubCategoryProcess.php?id=" + id, true);
    r.send();
}

function confirmDeleteSubcategory(id){
    var confirmation = confirm("This action will be deleted all the Brands & Models of this Sub Category! Do you want to continue?");

    if(confirmation){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = JSON.parse(r.responseText);
                if(t["sub"] == "success") {
                    alert("Sub Category deleted successfully with "+t["brd"]+" Brands & "+t["mdl"]+" Models");
                    loadOtherManages("sub");
                }else{
                    alert(t);
                }
            }
        }
    }

    r.open("GET", "confirmedDeleteSubCategoryProcess.php?id=" + id, true);
    r.send(); 
}

function admDeleteBrand(id){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == 0) {
                confirmDeleteBrand(id);
            }else{
                alert("There are "+t+" products listed with this Brand. If you want to delete this Brand, You have to manually delete that Products first.");
            }
        }
    }

    r.open("GET", "adminDeleteBrandProcess.php?id=" + id, true);
    r.send();
}

function confirmDeleteBrand(id){
    var confirmation = confirm("This action will be deleted all the Models of this this Brand! Do you want to continue?");

    if(confirmation){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = JSON.parse(r.responseText);
                if(t["brd"] == "success") {
                    alert("Brand deleted successfully with "+t["mdl"]+" Models");
                    loadOtherManages("brd");
                }else{
                    alert(t);
                }
            }
        }
    }

    r.open("GET", "confirmedDeleteBrandProcess.php?id=" + id, true);
    r.send(); 
}

function admDeleteModel(id){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == 0) {
                confirmDeleteModel(id);
            }else{
                alert("There are "+t+" products listed with this Model. If you want to delete this Model, You have to manually delete that Products first.");
            }
        }
    }

    r.open("GET", "adminDeleteModelProcess.php?id=" + id, true);
    r.send();
}

function confirmDeleteModel(id){

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if(t == "success") {
                alert("Models deleted successfully");
                loadOtherManages("mdl");
            }else{
                alert(t);
            }
        }
    }

    r.open("GET", "confirmedDeleteModelProcess.php?id=" + id, true);
    r.send(); 
}


function closeOtherModals(tab){
    window.location.reload();
    loadOtherManages(tab);
}

var get3;
function userProdChange(tab) {
    var all_tab = document.getElementById("Ptab1");
    var act_tab = document.getElementById("Ptab2");
    var pen_tab = document.getElementById("Ptab3");
    var dlt_tab = document.getElementById("Ptab4");

    if (tab == "all") {
        all_tab.classList = "nav-link active";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminUserProducts('1','all');
        get3 = "all";
    } else if (tab == "act") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link active";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link nav2";
        adminUserProducts('1','act');
        get3 = "act";
    } else if (tab == "dct") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link active";
        dlt_tab.classList = "nav-link nav2";
        adminUserProducts('1','dct');
        get3 = "dct";
    } else if (tab == "dlt") {
        all_tab.classList = "nav-link nav2";
        act_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        dlt_tab.classList = "nav-link active";
        adminUserProducts('1','dlt');
        get3 = "dlt";
    }
}

function adminUserProducts(page,type) {
    var sub_cate = document.getElementById("sltd_usr_sbc");
    var brand = document.getElementById("sltd_usr_brd");
    var model = document.getElementById("sltd_usr_mdl");
    var condi = document.getElementById("sltd_usr_con");
    var price_f = document.getElementById("sltd_usr_prf");
    var price_t = document.getElementById("sltd_usr_prt");
    var text = document.getElementById("sltd_usr_txt");
    var time = document.getElementById("sltd_usr_time");

    var umail = document.getElementById("sltd_usr_eml");
    var status = 0;

    var f = new FormData();
    f.append("sc", sub_cate.value);
    f.append("br", brand.value);
    f.append("md", model.value);
    f.append("cn", condi.value);
    f.append("pf", price_f.value);
    f.append("pt", price_t.value);
    f.append("tt", text.value);
    f.append("tm", time.value);
    f.append("status", status);
    f.append("um", umail.value);

    f.append("page",page);
    if(type == "get"){
        if(get == null){
            f.append("type","all");
        }else{
            f.append("type",get);
        }
    }else{
        f.append("type",type);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("ad_usr_pro_view").innerHTML = t;
        }
    }

    r.open("POST", "adminUsersProductLoadProcess.php", true);
    r.send(f);
}


function changeStatusUser(email,id){

var r = new XMLHttpRequest();
r.onreadystatechange = function () {
    if (r.readyState == 4) {
        var t = r.responseText;
        if (t == 1) {
            document.getElementById("status_up" + id).innerHTML = "Make this user Dectivated";
            document.getElementById("status_ua" + id).innerHTML = "Active";
            document.getElementById("status_up" + id).classList = "form-check-label t-dng";
            document.getElementById("status_ua" + id).classList = "t-suc";
        } else if (t == 2) {
            document.getElementById("status_up" + id).innerHTML = "Make this user Activated";
            document.getElementById("status_ua" + id).innerHTML = "Deactive";
            document.getElementById("status_up" + id).classList = "form-check-label t-suc";
            document.getElementById("status_ua" + id).classList = "text-warning";
        } else {
            alert(t);
        }
    }
};

r.open("GET", "changeUserStatusProcess.php?em=" + email, true);
r.send();
}

var get4;
function AdminOrderChange(tab) {
    var all_tab = document.getElementById("tabO1");
    var del_tab = document.getElementById("tabO2");
    var cof_tab = document.getElementById("tabO3");
    var pen_tab = document.getElementById("tabO4");
    var rtn_tab = document.getElementById("tabO5");

    if (tab == "all") {
        all_tab.classList = "nav-link active";
        del_tab.classList = "nav-link nav2";
        cof_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        rtn_tab.classList = "nav-link nav2";
        adminAllOrders('1','all');
        get4 = "all";
    } else if (tab == "del") {
        all_tab.classList = "nav-link nav2";
        del_tab.classList = "nav-link active";
        cof_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        rtn_tab.classList = "nav-link nav2";
        adminAllOrders('1','del');
        get4 = "del";
    } else if (tab == "cof") {
        all_tab.classList = "nav-link nav2";
        del_tab.classList = "nav-link nav2";
        cof_tab.classList = "nav-link active";
        pen_tab.classList = "nav-link nav2";
        rtn_tab.classList = "nav-link nav2";
        adminAllOrders('1','cof');
        get4 = "cof";
    } else if (tab == "pen") {
        all_tab.classList = "nav-link nav2";
        del_tab.classList = "nav-link nav2";
        cof_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link active";
        rtn_tab.classList = "nav-link nav2";
        adminAllOrders('1','pen');
        get4 = "pen";
    } else if (tab == "rtn") {
        all_tab.classList = "nav-link nav2";
        del_tab.classList = "nav-link nav2";
        cof_tab.classList = "nav-link nav2";
        pen_tab.classList = "nav-link nav2";
        rtn_tab.classList = "nav-link active";
        adminAllOrders('1','rtn');
        get4 = "rtn";
    }
}

function adminAllOrders(page,type) {
    var sub_cate = document.getElementById("adm_ord_sbc");
    var brand = document.getElementById("adm_ord_brd");
    var model = document.getElementById("adm_ord_mdl");
    var condi = document.getElementById("adm_ord_con");
    var title = document.getElementById("adm_ord_ttl");
    var oid = document.getElementById("adm_ord_id");
    var date_f = document.getElementById("adm_ord_df");
    var date_t = document.getElementById("adm_ord_dt");
    var email = document.getElementById("adm_all_em");
    var time = document.getElementById("ord_sort_time");
    var status = 0;

    var f = new FormData();
    f.append("sc", sub_cate.value);
    f.append("br", brand.value);
    f.append("md", model.value);
    f.append("cn", condi.value);
    f.append("tt", title.value);
    f.append("id", oid.value);
    f.append("df", date_f.value);
    f.append("dt", date_t.value);
    f.append("em", email.value);
    f.append("tm", time.value);
    f.append("status", status);
    f.append("page",page);
    if(type == "get"){
        if(get == null){
            f.append("type","all");
        }else{
            f.append("type",get4);
        }
    }else{
        f.append("type",type);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("ad_all_ord_view").innerHTML = t;
        }
    }

    r.open("POST", "adminAllOrdersLoadProcess.php", true);
    r.send(f);
}

function adminOrderStatusUpdate(iid){
    var status = document.getElementById("adm_chg_ost").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    }

    r.open("GET", "adminOrderStatusChangeProcess.php?iid=" + iid + "&stt=" + status, true);
    r.send();
}