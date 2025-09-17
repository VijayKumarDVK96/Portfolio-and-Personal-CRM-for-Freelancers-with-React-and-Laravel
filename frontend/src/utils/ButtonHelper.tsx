import { Button } from "@mui/material";
import type { ReactNode, MouseEventHandler } from "react";

interface ButtonHelperProps {
    text: string;
    variant?: "contained" | "outlined";
    icon?: ReactNode;
    onClickHandler?: MouseEventHandler<HTMLButtonElement>;
    style?: object;
}

const ButtonHelper: React.FC<ButtonHelperProps> = ({
    text,
    variant = "contained",
    icon,
    onClickHandler,
    style
}) => {
    const isOutlined = variant === "outlined";

    return (
        <Button
            variant={variant}
            startIcon={icon}
            onClick={onClickHandler}
            sx={{
                px: 3,
                py: 1.2,
                fontWeight: 600,
                transition: "all 0.3s ease-in-out",
                ...style,
                ...(isOutlined
                    ? {
                        borderColor: "primary.main",
                        color: "primary.main",
                        "&:hover": {
                            bgcolor: "primary.main",
                            color: "background.default",
                            borderColor: "primary.main",
                        },
                    }
                    : {
                        bgcolor: "primary.main",
                        color: "background.default",
                        "&:hover": {
                            bgcolor: "background.default",
                            color: "primary.main",
                            border: "1px solid",
                            borderColor: "primary.main",
                        },
                    }),
            }}
        >
            {text}
        </Button>
    );
};

export default ButtonHelper;