<template>
    <el-card :body-style="{ padding: '0px' }">
        <img
            src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png"
            class="image"
        />
        <div style="padding: 14px">
            <h5 style="margin: 0">
                $4.00
                <span style="text-decoration: line-through"
                    >${{
                        parseFloat(
                            Math.round(product.price * 100) / 100
                        ).toFixed(2)
                    }}</span
                >
                <el-tag size="small" type="danger"
                    >😍 {{ product.discount }} % Descuento</el-tag
                >
            </h5>
            <div class="bottom">
                <time class="time">{{ product.description }}</time>

                <el-button plain icon="Plus" circle />
            </div>
        </div>
    </el-card>
</template>
<script setup>
const props = defineProps({
    product: Object,
});
</script>
