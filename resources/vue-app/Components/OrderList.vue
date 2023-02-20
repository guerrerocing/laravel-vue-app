<template>
    <el-row :gutter="20">
        <el-col
            v-for="i in 12"
            :key="i"
            style="margin-top: 10px"
            :lg="{ span: 6 }"
            :md="{ span: 12 }"
            :sm="{ span: 24 }"
        >
            <el-card :body-style="{ padding: '0px' }" @click="onClickOrder(i)">
                <div style="padding: 14px">
                    <span>Yummy hamburger</span>
                    <div class="bottom">
                        <time class="time">{{ currentDate }}</time>
                        <el-tag size="small" type="success">Status</el-tag>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>
<script setup>
import { ref } from "vue";

const currentDate = ref(new Date());
const onClickOrder = (order) => {
    console.log(order);
};
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
