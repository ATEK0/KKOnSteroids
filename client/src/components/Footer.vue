
<template>
    <footer class="w-100 p-0 m-0 text-center p-3" style="background-color: white;">
        <div class="row">
            <div class="col-4">
                <a href="/products">Products</a> <br>
                <a href="/#categories">Categories</a> <br>
                <a href="/account">Account</a> <br>
            </div>
            <div class="col-4">
                Terms & Conditions <br>
                Our Company <br>
                Contacts <br>

            </div>
            <div class="col-4 d-flex flex-column align-items-center gap-1">
                Cant find what your are looking for?
                <a href="/product/request" class="w-100"><button class="btn btn-primary-outlined w-50">Request Product</button></a>
            </div>
        </div>
    </footer>
</template>

<script>

export default {
    name: 'footerbar'
};

</script>
