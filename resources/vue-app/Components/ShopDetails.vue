<style>
.card-header {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left: 40px;
    padding-right: 40px;
}
.box-card {
    margin: 40px;
}

.box-card > .el-card__header {
    padding: 0;
}
.banner {
    background-image: url("https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2970&q=80");
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: cover;
}
.shop-avatar {
    position: absolute;
    top: -80px;
    right: 50px;
}
</style>
<template>
    <div>
        <el-space fill size="large" style="width: 100%">
            <el-card class="box-card">
                <template #header>
                    <div
                        style="width: 100%; height: 200px"
                        class="banner"
                    ></div>
                    <div class="card-header">
                        <div>
                            <h3>{{ shop.name }}</h3>
                            <div
                                style="
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                "
                            >
                                <el-icon style="margin-right: 8px"
                                    ><Location
                                /></el-icon>
                                <p>{{ shop.address }}</p>
                            </div>
                            <div
                                style="
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                "
                            >
                                <el-icon style="margin-right: 8px"
                                    ><Clock
                                /></el-icon>
                                <p>
                                    {{
                                        `${shop.openingAt} - ${shop.closingAt}`
                                    }}
                                </p>
                            </div>
                        </div>
                        <el-avatar
                            class="shop-avatar"
                            :size="160"
                            src="https://images.unsplash.com/photo-1616696269274-ddc39cecd3f8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80"
                        />
                        <el-button
                            style="margin-top: 80px"
                            type="danger"
                            round
                            color="#ff18a6"
                            icon="Plus"
                            @click="createProduct = true"
                            >Nuevo Producto
                        </el-button>
                    </div>
                </template>

                <product-list :products="products" />
            </el-card>
        </el-space>
        <el-drawer
            v-model="createProduct"
            title="Crea un Nuevo Producto"
            direction="ltr"
            size="50%"
        >
            <product-form :shop-id="props.shop.id" />
        </el-drawer>
    </div>
</template>

<script setup>
import ProductList from "@/Components/ProductList.vue";
import ProductForm from "@/Components/ProductForm.vue";
import { computed, ref, watch } from "vue";
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";

const props = defineProps({
    shop: Object,
});

const createProduct = ref(false);

const { result, loading } = useQuery(
    gql`
        query productsQuery($shop_id: ID!) {
            productByShopId(shop_id: $shop_id, first: 50) {
                edges {
                    node {
                        id
                        name
                        description
                        price
                        discount
                    }
                }
            }
        }
    `,
    () => ({
        shop_id: props.shop.id,
    }),
    { pollInterval: 1000 }
);

const products = computed(() => {
    return result?.value?.productByShopId.edges ?? [];
});
</script>
