import axios from "axios";

const $axios = axios.create({
    baseURL: "http://task.local/api/v1",
    //baseURL: 'http://localhost:8000/api/v1',
    timeout: 20000,
});

$axios.interceptors.request.use(
    (config) => ({
        ...config,
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    }),
    (error) => {
        console.log(error);
    }
);
export { $axios };
