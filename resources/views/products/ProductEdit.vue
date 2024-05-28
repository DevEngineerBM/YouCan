<template>
  <div>
    <h1>Edit Product</h1>
    <form @submit.prevent="handleSubmit">
      <div>
        <label for="product-name">Product Name:</label>
        <input id="product-name" v-model="product.name" placeholder="Product Name" />
      </div>
      <div>
        <label for="product-price">Product Price:</label>
        <input id="product-price" v-model.number="product.price" placeholder="Product Price" type="number" />
      </div>
      <div>
        <label for="product-description">Product Description:</label>
        <textarea id="product-description" v-model="product.description" placeholder="Product Description"></textarea>
      </div>
      <div>
        <label for="product-category">Product Category:</label>
        <div v-for="(category, index) in categories" :key="category.id">
          <input type="checkbox" :id="'category-' + category.id" :value="category.id" v-model="product.category_ids" />
          <label :for="'category-' + category.id">{{ category.name }}</label>
        </div>
      </div>
      <button type="submit" :disabled="loading">Update Product</button>
      <div v-if="loading">Updating...</div>
      <div v-if="error">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router';
//original 
const product = ref({
  name: '', 
  price: 0,
  description: '',
  category_ids: [] 
});

const loading = ref(false);
const error = ref('');
const categories = ref([]);

const fetchProductDetails = async () => {
  try {
    loading.value = true;
    const productId = route.params.id;
    const productResponse = await axios.get(`/api/products/${productId}`);
    const categoriesResponse = await axios.get('/api/categories');

    // Update product.value with the fetched data
    product.value = productResponse.data;
    product.value.category_ids = productResponse.data.categories.map(cat => cat.id) || [];

    categories.value = categoriesResponse.data;
  } catch (err) {
    error.value = `Error fetching product details: ${err.message}`;
  } finally {
    loading.value = false;
  }
};

onMounted(fetchProductDetails);

const router = useRouter();
const route = useRoute();

const handleSubmit = async () => {
  loading.value = true;
  error.value = '';

  const formData = {
    name: product.value.name,
    price: product.value.price,
    description: product.value.description,
    category_ids: product.value.category_ids
  };

  try {
    const productId = route.params.id;
    const response = await axios.put(`/api/products/${productId}`, formData);
    console.log('Update Response:', response.data);
    router.push({ name: 'products.index' });
  } catch (err) {
    error.value = `Error updating product: ${err.message}`;
    console.error(err.response.data);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>

</style>