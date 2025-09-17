import React from "react";
import { Box, Grid, Typography, Avatar } from "@mui/material";
import CountUp from "react-countup";
import { useInView } from "react-intersection-observer";
import SectionTitle from "../utils/SectionTitle";
import ParagraphHelper from "../utils/ParagraphHelper";
import { useMain } from "../contexts/MainContext";

// type InfoItemProps = {
//     label: string;
//     value: React.ReactNode;
//     xs?: number;
// };

// const InfoItem: React.FC<InfoItemProps> = ({ label, value, xs = 6 }) => (
//     <Grid size={{ xs }}>
//         <Typography variant="subtitle2" sx={{ color: "primary.main", fontWeight: 600 }}>
//             {label}
//         </Typography>
//         <Typography sx={{ color: "text.primary" }}>{value}</Typography>
//     </Grid>
// );

type StatCardProps = {
    value: number;
    label: string;
    suffix?: string;
    duration?: number;
    visible: boolean;
};

const StatCard: React.FC<StatCardProps> = ({
    value,
    label,
    suffix = "+",
    duration = 2,
    visible,
}) => {
    return (
        <Grid size={{ xs: 12, sm: 4 }}>
            <Typography variant="h3" fontWeight="bold" sx={{ color: "primary.main" }}>
                {visible ? <CountUp end={value} duration={duration} /> : value}
                {suffix}
            </Typography>
            <Typography variant="body1" color="text.primary">
                {label}
            </Typography>
        </Grid>
    );
};

const About: React.FC = () => {
    const { ref, inView } = useInView({
        triggerOnce: true,
        threshold: 0.3,
    });

    const { mainData } = useMain();

    if (!mainData) return null;

    // console.log(mainData)

    return (
        <Box
            id="about"
            sx={{
                bgcolor: "background.default",
                color: "white",
                minHeight: "100vh",
            }}
        >
            {/* Stats */}
            <Grid
                ref={ref}
                container
                spacing={4}
                justifyContent="center"
                textAlign="center"
                mb={15}
                sx={{ background: '#000', padding: '50px 0'}}
            >
                <StatCard value={new Date().getFullYear() - 2017} label="Years of Experience" visible={inView} />
                <StatCard value={15} label="Projects Completed" visible={inView} />
                <StatCard value={20} label="Technologies Mastered" visible={inView} />
            </Grid>
            
            <SectionTitle title="About Me" />
            
            <Grid container spacing={3} justifyContent="center" alignItems="center">
                <Grid size={{ xs: 12, md: 3 }}>
                    <Avatar
                        sx={{
                            width: 240,
                            height: 240,
                            bgcolor: 'primary.main',
                            color: "black",
                            fontSize: "3rem",
                            fontWeight: "bold",
                            borderRadius: 4,
                            mx: "auto",
                            boxShadow: 3,
                        }}
                    >
                        DM
                    </Avatar>
                </Grid>
                
                <Grid size={{ xs: 12, md: 5 }} sx={{ px: 3 }}>
                    <Typography variant="h5" gutterBottom fontWeight="bold">Senior Software Developer</Typography>

                    <ParagraphHelper text={mainData.data.details.about_me} />
                    
                    {/* <Grid container spacing={2} mt={2}>
                        <InfoItem label="Location:" value="Bengaluru, India" />
                        <InfoItem
                            label="Experience:"
                            value={`${new Date().getFullYear() - 2017}+ years`}
                        />
                        <InfoItem label="Email:" value="vijay.dvk96@gmail.com" />
                        <InfoItem label="Phone:" value="7373849255" />
                    </Grid> */}
                </Grid>
            </Grid>
        </Box>
    );
};

export default About;
