<template>
    <el-form
        ref="form"
        :model="shopFormValues"
        label-width="auto"
        :label-position="labelPosition"
        :size="size"
    >
        <el-form-item label="Nombre de Tienda">
            <el-input v-model="shopFormValues.name" />
        </el-form-item>
        <el-form-item label="Descripcion de Tienda">
            <el-input
                v-model="shopFormValues.description"
                autosize
                type="textarea"
                placeholder="Descripcion"
            />
        </el-form-item>
        <el-form-item label="Direccion de Tienda">
            <el-input
                v-model="shopFormValues.address"
                autosize
                type="textarea"
                placeholder="Direccion"
            />
        </el-form-item>
        <el-form-item
            label="Horario de Atencion"
            style="display: flex; justify-content: space-between"
        >
            <el-time-picker
                is-range
                v-model="shopFormValues.times"
                start-placeholder="Hora de Apertura"
                end-placeholder="Hora de Clausura"
                range-separator="A"
            />
        </el-form-item>
        <el-form-item>
            <el-button color="#ff18a6" @click="createShop" :loading="isLoading"
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
import { format } from "date-fns";

const size = ref("default");
const labelPosition = ref("right");

const shopFormValues = reactive({
    name: "",
    description: "",
    address: "",
    times: [new Date(), new Date()],
});

const {
    mutate: createShop,
    loading: isLoading,
    onDone,
} = useMutation(
    gql`
        mutation createShop($input: ShopInput!) {
            createShop(input: $input) {
                shopEdge {
                    node {
                        id
                        name
                        description
                        address
                        closingAt
                        openingAt
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
                name: shopFormValues.name,
                description: shopFormValues.description,
                address: shopFormValues.address,
                openingAt: format(shopFormValues.times[0], "hh:mm:ss"),
                closingAt: format(shopFormValues.times[1], "hh:mm:ss"),
            },
        },
    })
);

onDone(
    ({
        data: {
            createShop: { userErrors },
        },
    }) => {
        if (userErrors.length) {
            ElNotification({
                title: "Opps 😮",
                message: userErrors[0].message,
                type: "error",
            });
        } else {
            shopFormValues.name = "";
            shopFormValues.address = "";
            shopFormValues.description = "";
            shopFormValues.times = [new Date(), new Date()];
            ElNotification({
                title: "Excelente 🥳",
                message: "Se ha creado una nueva tienda.",
                type: "success",
            });
        }
    }
);
</script>
