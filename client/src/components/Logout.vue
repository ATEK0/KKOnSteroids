<script>

export default {
    name: 'Logout',
    beforeMount() {
        this.logoutUser();
    },
    methods: {
        logoutUser() {
            if ($cookies.get("jwtoken")) {
                
                $cookies.remove("jwtoken")
                localStorage.removeItem("userLogged")

                window.location.href ="/login"

            } else {

                window.location.href = '/'

            }
        }
    }
};

</script>