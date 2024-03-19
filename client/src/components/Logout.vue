<script>

import axios from 'axios';
import { apiLink } from '../config.js';


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

                // this.$router.push('/login')
                window.location.href ="/login"
            } else {
                // this.$router.push('/')
                window.location.href = '/'
            }

        }

    }
};
</script>