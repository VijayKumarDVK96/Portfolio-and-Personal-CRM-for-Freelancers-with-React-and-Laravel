import React from "react";
import { Timeline, TimelineItem, TimelineSeparator, TimelineConnector, TimelineContent, TimelineDot, timelineItemClasses, } from "@mui/lab";
import { Typography, Box, Grid, Paper, Avatar, useTheme, } from "@mui/material";
import SchoolIcon from "@mui/icons-material/School";
import WorkIcon from "@mui/icons-material/Work";
import SectionTitle from "../utils/SectionTitle";
import { useMain } from "../contexts/MainContext";

interface TimelineData {
    year: string;
    title: string;
    organization: string;
    description: string | null;
    logo: string;
}

interface TimelineSectionProps {
    icon: React.ReactElement;
    title: string;
    data: TimelineData[];
}

const TimelineSection: React.FC<TimelineSectionProps> = ({ icon, title, data }) => {
    const theme = useTheme();

    return (
        <Grid size={{ xs: 12, md: 6 }}>
            <Box
                sx={{
                    display: "flex",
                    alignItems: "center",
                    mb: 3,
                    color: theme.palette.primary.main,
                }}
            >
                <Box
                    sx={{
                        bgcolor: "#121821",
                        borderRadius: "50%",
                        p: 1.2,
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        mr: 1,
                        boxShadow: "0 0 8px rgba(166, 255, 0, 0.5)",
                    }}
                >
                    {React.cloneElement(icon, {
                        sx: { fontSize: 28, color: theme.palette.primary.main },
                    } as React.HTMLAttributes<HTMLElement>)}
                </Box>
                <Typography variant="h6" fontWeight="bold">
                    {title}
                </Typography>
            </Box>

            {/* Timeline */}
            <Timeline
                sx={{
                    [`& .${timelineItemClasses.root}:before`]: {
                        flex: 0,
                        padding: 0,
                    },
                }}
            >
                {data.map((item, idx) => (
                    <TimelineItem key={idx}>
                        <TimelineSeparator>
                            <TimelineDot sx={{ bgcolor: theme.palette.primary.main, p: 0.3 }}>
                                <Avatar src={item.logo} alt={item.organization} sx={{ width: 70, height: 70, "& img": { objectFit: 'contain' } }} />
                            </TimelineDot>
                            {idx < data.length - 1 && (
                                <TimelineConnector sx={{ bgcolor: theme.palette.primary.main }} />
                            )}
                        </TimelineSeparator>

                        <TimelineContent>
                            <Paper
                                sx={{
                                    p: 2,
                                    backgroundColor: "#121821",
                                }}
                                elevation={3}
                            >
                                <Typography fontWeight="bold" variant="subtitle1">
                                    {item.title}
                                </Typography>
                                <Typography
                                    sx={{
                                        color: theme.palette.primary.main,
                                        fontWeight: 600,
                                    }}
                                >
                                    {item.organization}
                                </Typography>
                                <Typography sx={{ fontSize: 14, color: theme.palette.primary.main }}>
                                    {item.year}
                                </Typography>
                                {item.description && (
                                    <Typography variant="body2" color="text.primary" sx={{ mt: 2, whiteSpace: "pre-line", textAlign: "justify" }}>
                                        {item.description}
                                    </Typography>
                                )}
                            </Paper>
                        </TimelineContent>
                    </TimelineItem>
                ))}
            </Timeline>
        </Grid>
    );
};

const Resume: React.FC = () => {
    const { mainData } = useMain();

    if (!mainData) return null;

    // Convert API resume data to TimelineData[]
    const educationData: TimelineData[] = mainData.data.resume.education.map((edu: any) => ({
        year: `${edu.start} - ${edu.end}`,
        title: edu.title,
        organization: edu.company,
        description: edu.description,
        logo: edu.image,
    }));

    const experienceData: TimelineData[] = mainData.data.resume.experience.map((exp: any) => ({
        year: `${exp.start} - ${exp.end}`,
        title: exp.title,
        organization: exp.company,
        description: exp.description,
        logo: exp.image,
    }));

    return (
        <Box
            sx={{
                backgroundColor: "#0a0f1a",
                p: 4,
                color: "white",
                margin: "auto",
            }}
            maxWidth={1400}
        >
            <SectionTitle title="My Resume" />

            <Grid container spacing={4}>
                <TimelineSection icon={<SchoolIcon />} title="Education" data={educationData} />
                <TimelineSection icon={<WorkIcon />} title="Experience" data={experienceData} />
            </Grid>
        </Box>
    );
};

export default Resume;
