
import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/call/cartera`;

export const DashboardService = {
    async dashboard(params) {
        return await axios.get(`${apiUrl}/dashboard`, {
            params: params,
        });
    },
};
