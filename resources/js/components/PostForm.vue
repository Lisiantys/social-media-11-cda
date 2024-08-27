<template>
    <div class="post-form-container">
        <h2>{{ post ? "Modifier le post" : "Créer un post" }}</h2>
        <hr>
        <form @submit.prevent="submitForm" class="post-form">
            <h3>Tag :</h3>
            <input
                type="text"
                v-model="form.tags"
                placeholder="Tags"
                required
            />
            <h3>Description :</h3>
            <textarea
                v-model="form.content"
                placeholder="Contenu"
                required
            ></textarea>
            <button type="submit">
                {{ post ? "Mettre à jour" : "Valider" }}
            </button>
        </form>
    </div>
</template>

<script>
import { ref, watchEffect } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    props: {
        post: {
            type: Object,
            default: null,
        },
    },
    setup(props) {
        const form = ref({
            content: "",
            tags: "",
        });
        const router = useRouter();

        watchEffect(() => {
            if (props.post) {
                form.value.content = props.post.content;
                form.value.tags = props.post.tags;
            }
        });

        const submitForm = async () => {
            try {
                if (props.post) {
                    // Update existing post
                    const response = await axios.put(
                        `/api/posts/${props.post.id}`,
                        form.value
                    );
                    window.location.reload();
                } else {
                    // Create new post
                    const response = await axios.post("/api/posts", form.value);
                    const postId = response.data.post.id; // Assuming the API returns the created post with its ID
                    router.push(`/posts/${postId}`);
                }
            } catch (error) {
                console.log("Error saving post:", error);
            }
        };

        return { form, submitForm };
    },
};
</script>

<style scoped>
.post-form-container {
    margin: 40px auto;
    padding: 20px;
    background-color: #e6e6e6;
    border-radius: 10px;
}

.post-form-container h2 {
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.post-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

h3{
    font-size: 20px;
}

textarea,
input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

textarea:focus,
input:focus {
    border-color: #007bff;
    outline: none;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

button:focus {
    outline: none;
}

button:active {
    background-color: #003f7f;
}
</style>
