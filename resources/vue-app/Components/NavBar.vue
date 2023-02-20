<template>
    <el-menu
        :default-active="activeRoute"
        class="el-menu-demo"
        mode="horizontal"
        :ellipsis="false"
        active-text-color="magenta"
        router
    >
        <el-menu-item>
            <h3 style="padding: 0px; margin: 0">Delivery App</h3>
        </el-menu-item>
        <div class="flex-grow" />
        <el-menu-item index="home" :route="{ name: 'home' }"
            >Inicio</el-menu-item
        >
        <el-menu-item index="orders" :route="{ name: 'orders' }"
            >Ordenes</el-menu-item
        >
        <el-menu-item index="cart" :route="{ name: 'cart' }"
            >Carrito</el-menu-item
        >
        <el-button
            v-if="activeRoute == 'home'"
            type="danger"
            round
            color="#ff18a6"
            style="align-self: center"
            @click="createShop = true"
            >Nueva Tienda</el-button
        >
    </el-menu>
    <el-drawer
        v-model="createShop"
        title="Crea una Nueva Tienda"
        direction="ltr"
        size="50%"
    >
        <shop-form />
    </el-drawer>
    <router-view></router-view>
</template>

<script setup>
import { watch, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import ShopForm from "@/Components/ShopForm.vue";

const router = useRouter();
const route = useRoute();
const activeRoute = ref("");
const createShop = ref(false);

watch(
    () => route.name,
    (change) => {
        if (route.name) {
            activeRoute.value = route.name;
            router.push({ to: route.name });
        }
    }
);
</script>
