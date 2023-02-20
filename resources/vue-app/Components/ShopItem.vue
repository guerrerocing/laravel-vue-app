<template>
    <el-card :body-style="{ padding: '0px' }" @click="onClickShop(shop.id)">
        <img
            src="https://source.unsplash.com/1600x900/?restaurant"
            class="image"
        />
        <div style="padding: 14px">
            <span>{{ shop.name }}</span>
            <div class="bottom">
                <time class="time">{{ shop.description }}</time>
                <el-button text class="button" icon="Goods">{{
                    shop.products.edges.length
                }}</el-button>
            </div>
        </div>
    </el-card>
</template>
<script setup>
import { useRouter } from "vue-router";

const props = defineProps({
    shop: Object,
});
const router = useRouter();
const onClickShop = (shop) => {
    router.push({ name: "shop", params: { id: shop } });
};
</script>
