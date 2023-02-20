import { createWebHistory, createRouter } from "vue-router";

import Shops from "@/Views/Shops/Shops.vue";
import Cart from "@/Views/Cart/Cart.vue";
import Orders from "@/Views/Orders/Orders.vue";
import Order from "@/Views/Orders/Order.vue";
import Shop from "@/Views/Shops/Shop.vue";

const routes = [
    { name: "home", path: "/", component: Shops },
    { name: "cart", path: "/cart", component: Cart },
    { name: "orders", path: "/orders", component: Orders },
    { name: "order", path: "/orders/:id", component: Order },
    { name: "shop", path: "/shops/:id", component: Shop },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
