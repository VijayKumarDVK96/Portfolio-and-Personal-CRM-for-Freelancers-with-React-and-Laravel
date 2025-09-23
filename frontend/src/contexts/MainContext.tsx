import React, { createContext, useContext, useEffect, useState } from "react";
import ApiHelper from "../utils/ApiHelper";

export interface MainApiData {
    status: string;
    data: {
        details: any;
        resume: any;
        skills: any[];
        projects: any[];
        certifications: any[];
    };
}

interface MainContextType {
    mainData: MainApiData | null;
    loading: boolean;
    error: string | null;
    refetch: () => Promise<void>;
}

const MainContext = createContext<MainContextType | undefined>(undefined);

export const MainProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
    const [mainData, setMainData] = useState<MainApiData | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    const fetchMainData = async () => {
        try {
            setLoading(true);
            setError(null);
            const res = await ApiHelper<MainApiData>("main", "get");
            setMainData(res.data);
        } catch (err: any) {
            setError(err?.response?.data?.message || "Failed to fetch main data");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        const win = window as any;
        if (win.__landingDataFetched) return;
        win.__landingDataFetched = true;
        
        fetchMainData();
    }, []);

    return (
        <MainContext.Provider
            value={{
                mainData,
                loading,
                error,
                refetch: fetchMainData,
            }}
        >
            {children}
        </MainContext.Provider>
    );
};

// Hook for consuming
export const useMain = () => {
    const ctx = useContext(MainContext);
    if (!ctx) throw new Error("useMain must be used within MainProvider");
    return ctx;
};
