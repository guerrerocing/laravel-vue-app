<template>
    <el-row :gutter="20">
        <el-col :span="24" v-if="!shops.length"
            ><el-empty description="No hay tiendas disponibles"
        /></el-col>

        <el-col
            v-else
            v-for="{ node } in shops"
            :key="node.id"
            :lg="{ span: 6 }"
            :md="{ span: 12 }"
            :sm="{ span: 24 }"
            :xs="{ span: 24 }"
            style="margin-top: 10px"
        >
            <shop-item :shop="node" />
        </el-col>
    </el-row>
</template>
<script setup>
import ShopItem from "@/Components/ShopItem.vue";
const props = defineProps({
    shops: Array,
    isLoading: Boolean,
});
</script>

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

.button {
    padding: 0;
    min-height: auto;
}

.image {
    width: 100%;
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
