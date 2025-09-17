import type { ReactNode } from 'react';
import { IconButton, Tooltip } from '@mui/material';

type IconButtonHelperProps = {
  title: string;
  icon: ReactNode;
}

const IconButtonHelper: React.FC<IconButtonHelperProps> = ({ title, icon }) => {
  return (
    <Tooltip title={title} aria-label={`${title.toLowerCase()}-button-helper`}>
        <IconButton size="small" aria-label={`${title.toLowerCase()}-button`}>
            {icon}
        </IconButton>
    </Tooltip>
  );
}

export default IconButtonHelper;