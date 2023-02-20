<template>
    <div>
        <shop-details :shop="shop" v-if="shop" />
    </div>
</template>
<script setup>
import ShopDetails from "@/Components/ShopDetails.vue";
import { computed, ref, watch, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";

const route = useRoute();
const shopId = ref("");

const shop = computed(() => {
    return result?.value?.shopById;
});

const { result, loading } = useQuery(
    gql`
        query shopQuery($id: ID!) {
            shopById(id: $id) {
                id
                name
                description
                address
                closingAt
                openingAt
            }
        }
    `,
    () => ({
        id: shopId.value,
    }),
    { pollInterval: 1000 }
);

onMounted(() => {
    shopId.value = route.params.id;
});
</script>
