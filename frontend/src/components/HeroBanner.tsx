import { Box, Typography, Stack } from "@mui/material";
import DownloadIcon from "@mui/icons-material/CloudDownload";
import { GitHub, LinkedIn, Email } from "@mui/icons-material";
import { motion } from "framer-motion";
import useTypewriter from "../hooks/useTypewriter";
import ButtonHelper from "../utils/ButtonHelper";
import IconButtonHelper from "../utils/IconButtonHelper";
import { useMain } from "../contexts/MainContext";
import { useEffect, useState, type JSX } from "react";

const MotionBox = motion(Box);

const neonTextStyle = {
    color: "primary.main",
    fontFamily: "'Kelly Slab', cursive",
    fontWeight: 700,
};

interface SocialLink {
    title: string;
    icon: JSX.Element;
    url: string;
}

export default function HeroBanner() {
    const { mainData } = useMain();
    const [contact, setContact] = useState<any>(null);

    useEffect(() => {
        if (mainData?.data?.details) {
            setContact(mainData.data.details);
        }
    }, [mainData]);

    const socialLinks: SocialLink[] = contact
        ? [
            { title: "GitHub", icon: <GitHub />, url: contact.github },
            { title: "LinkedIn", icon: <LinkedIn />, url: contact.linkedin },
            { title: "Email", icon: <Email />, url: `mailto:${contact.email}` },
        ].filter(Boolean) as SocialLink[]
        : [];

    const hero = {
        greeting: "Hello, I'm",
        name: "Vijayakumar D",
        roles: ["Senior Software Developer", "Frontend Developer"],
        description:
            '“Passionate about creating exceptional web experiences with modern technologies. I specialize in building responsive, user-friendly applications that drive business value.”',
    };

    const { text, cursor } = useTypewriter({
        words: hero.roles,
        loop: true,
        typingSpeed: 70,
        deletingSpeed: 100,
        delayBetween: 2200,
    });

    return (
        <Box
            component="section"
            sx={{
                minHeight: "110vh",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                position: "relative",
                px: 3,
                textAlign: "center",
                backgroundImage: "url('../images/banner-background.jpg')",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "top center",
                backgroundSize: "cover",
            }}
        >
            {/* Overlay */}
            <Box
                sx={{
                    position: "absolute",
                    inset: 0,
                    backgroundColor: "rgba(0,0,0,0.7)",
                    zIndex: 0,
                    animation: "fadeOverlay 1s infinite alternate",
                    "@keyframes fadeOverlay": {
                        from: { backgroundColor: "rgba(0,0,0,0.7)" },
                        to: { backgroundColor: "rgba(0,0,0,0.1)" },
                    },
                }}
            />

            <MotionBox
                sx={{
                    zIndex: 2,
                    maxWidth: 1100,
                    width: "100%",
                }}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.7 }}
            >
                <Typography
                    variant="h2"
                    component="h1"
                    sx={{
                        fontSize: { xs: "2.2rem", md: "3.8rem" },
                        fontWeight: 800,
                        color: "text.primary",
                    }}
                >
                    <Box component="span" sx={{ mr: 1 }}>
                        {hero.greeting}
                    </Box>
                    <Box component="span" sx={{ ...neonTextStyle }}>
                        {hero.name}
                    </Box>
                </Typography>

                <Typography
                    variant="h5"
                    sx={{
                        mt: 1,
                        color: "text.primary",
                        fontWeight: 600,
                    }}
                >
                    <Box component="span">{text}</Box>
                    <Box component="span" sx={{ color: "primary.main" }}>
                        {cursor}
                    </Box>
                </Typography>

                <Typography
                    variant="body1"
                    sx={{
                        mt: 3,
                        color: "#fff",
                        maxWidth: 840,
                        mx: "auto",
                        lineHeight: 1.6,
                        fontFamily: "'EB Garamond', cursive",
                        fontStyle: "italic",
                        fontSize: "1.4rem",
                    }}
                >
                    {hero.description}
                </Typography>

                <Stack
                    direction={{ xs: "column", sm: "row" }}
                    spacing={2}
                    justifyContent="center"
                    alignItems="center"
                    sx={{ mt: 4 }}
                >
                    <ButtonHelper text="Download CV" icon={<DownloadIcon />} />
                    <ButtonHelper text="View Projects" variant="outlined" />
                </Stack>

                {/* social icons */}
                <Stack direction="row" spacing={2} justifyContent="center" sx={{ mt: 4 }}>
                    {socialLinks.map((item, idx) => (
                        <IconButtonHelper
                            key={idx}
                            title={item.title}
                            icon={item.icon}
                            url={item.url}
                        />
                    ))}
                </Stack>

                {/* down arrow */}
                <Box className="down-arrow" sx={{ mt: 6 }}>
                    <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
                        <path
                            d="M1 1L7 7L13 1"
                            stroke="rgba(124,255,0,0.85)"
                            strokeWidth="1.5"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                        />
                    </svg>
                </Box>
            </MotionBox>
        </Box>
    );
}
