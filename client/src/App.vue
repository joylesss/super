<template>
    <div id="app">
        <div id="nav">
            <router-link to="/">Home</router-link>
            |
            <router-link to="/contact">Contact</router-link>
            |
            <router-link to="/dashboard">Dashboard</router-link>
            |
            <router-link to="/login">Login</router-link>
        </div>

        <Navigation />
        <router-view/>
    </div>
</template>

<script>
    import Navigation from "@/components/section/Navigation";

    export default {
        components: {
            Navigation
        }
    }
</script>
