<template>
    <el-form
        ref="form"
        :model="productFormValues"
        label-width="auto"
        :label-position="labelPosition"
        :size="size"
    >
        <el-form-item label="Nombre del producto">
            <el-input v-model="productFormValues.name" />
        </el-form-item>
        <el-form-item label="Descripcion del producto">
            <el-input
                v-model="productFormValues.description"
                autosize
                type="textarea"
                placeholder="Descripcion"
            />
        </el-form-item>
        <el-form-item label="Precio Regular del Producto">
            <el-input
                v-model="productFormValues.price"
                autosize
                type="number"
                placeholder="Precio"
            />
        </el-form-item>
        <el-form-item label="Descuento a aplicar al producto en %">
            <el-input
                v-model="productFormValues.discount"
                autosize
                type="number"
                placeholder="Descuento"
            />
        </el-form-item>

        <el-form-item>
            <el-button
                color="#ff18a6"
                @click="createProduct"
                :loading="isLoading"
                >Crear</el-button
            >
        </el-form-item>
    </el-form>
</template>
<script setup>
import { reactive, ref } from "vue";
import { useMutation } from "@vue/apollo-composable";
import { ElNotification } from "element-plus";
import gql from "graphql-tag";

const props = defineProps({
    shopId: String,
});

const size = ref("default");
const labelPosition = ref("right");

const productFormValues = reactive({
    name: "",
    description: "",
    price: "",
    discount: "",
});

const {
    mutate: createProduct,
    loading: isLoading,
    onDone,
} = useMutation(
    gql`
        mutation createShop($input: ProductInput!) {
            createProduct(input: $input) {
                productEdge {
                    node {
                        id
                        name
                        description
                        price
                        discount
                    }
                }
                userErrors {
                    message
                }
            }
        }
    `,
    () => ({
        variables: {
            input: {
                shopId: props.shopId,
                name: productFormValues.name,
                description: productFormValues.description,
                price: parseFloat(productFormValues.price),
                discount: parseInt(productFormValues.discount),
            },
        },
    })
);

onDone(
    ({
        data: {
            createProduct: { userErrors },
        },
    }) => {
        if (userErrors.length) {
            ElNotification({
                title: "Opps 😮",
                message: userErrors[0].message,
                type: "error",
            });
        } else {
            productFormValues.name = "";
            productFormValues.price = "";
            productFormValues.description = "";
            productFormValues.discount = "";
            ElNotification({
                title: "Excelente 🥳",
                message: "Se ha creado un nuevo producto.",
                type: "success",
            });
        }
    }
);
</script>
