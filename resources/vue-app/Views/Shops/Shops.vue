<style>
.is-active > .custom-tabs-label {
    color: magenta;
}
</style>
<template>
    <div style="position: relative">
        <el-tabs v-model="activeName" class="demo-tabs" stretch type="card">
            <el-tab-pane label="" name="first">
                <template #label>
                    <span class="custom-tabs-label">
                        <span>Con Stock</span>
                    </span>
                </template>

                <shop-list :shops="witStock" :isLoading="loading" />
            </el-tab-pane>
            <el-tab-pane name="second">
                <template #label>
                    <span class="custom-tabs-label">
                        <span>Sin Stock</span>
                    </span>
                </template>

                <shop-list :shops="witOutStock" :isLoading="loading" />
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script setup>
import { computed, ref, watch } from "vue";
import ShopList from "@/Components/ShopList.vue";
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";

const activeName = ref("first");

const { result, loading } = useQuery(
    gql`
        query shopsQuery {
            shopsWithStock(first: 30) {
                edges {
                    node {
                        id
                        name
                        description
                        address
                        closingAt
                        openingAt
                        products(first: 20) {
                            edges {
                                node {
                                    id
                                }
                            }
                        }
                    }
                }
            }
            shopsWithOutStock(first: 30) {
                edges {
                    node {
                        id
                        name
                        description
                        address
                        closingAt
                        openingAt
                        products(first: 20) {
                            edges {
                                node {
                                    id
                                }
                            }
                        }
                    }
                }
            }
        }
    `,
    null,
    { pollInterval: 1000 }
);

const witOutStock = computed(() => {
    return result?.value?.shopsWithOutStock.edges ?? [];
});

const witStock = computed(() => {
    return result?.value?.shopsWithStock.edges ?? [];
});
</script>
