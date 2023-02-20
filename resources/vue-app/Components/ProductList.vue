<style>
.time {
    font-size: 12px;
    color: #999;
}

.bottom {
    margin-top: 13px;
    line-height: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.botton > .el-button {
    padding: 8px 15px;
    min-height: auto;
}

.image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.el-row {
    margin-bottom: 20px;
}
.el-row:last-child {
    margin-bottom: 0;
}
.el-col {
    border-radius: 4px;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}
</style>

<template>
    <el-row :gutter="20">
        <el-col :span="24" v-if="!products.length"
            ><el-empty description="No hay productos disponibles"
        /></el-col>
        <el-col
            v-else
            v-for="{ node } in products"
            :key="node.id"
            :lg="{ span: 6 }"
            :md="{ span: 8 }"
            :sm="{ span: 24 }"
            :xs="{ span: 24 }"
            style="margin-top: 10px"
        >
            <product-item :product="node" />
        </el-col>
    </el-row>
</template>
<script setup>
import ProductItem from "@/Components/ProductItem.vue";
const props = defineProps({
    products: Array,
});
</script>
