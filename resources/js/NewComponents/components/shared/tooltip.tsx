import * as TooltipPrimitive from "@radix-ui/react-tooltip";
import React from "react";

export function Tooltip({
  trigger,
  tooltip
}: {
  trigger: React.ReactNode,
  tooltip: React.ReactNode
}) {
  return (
    <TooltipPrimitive.Provider>
      <TooltipPrimitive.Root delayDuration={10}>
        <TooltipPrimitive.Trigger asChild>
          {trigger}
        </TooltipPrimitive.Trigger>
        <TooltipPrimitive.Portal>
          <TooltipPrimitive.Content
            className="z-50 overflow-hidden rounded-md bg-black px-3 py-1.5 text-sm text-white animate-in fade-in-0 zoom-in-95 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2"
            sideOffset={5}
          >
            {tooltip}
          </TooltipPrimitive.Content>
        </TooltipPrimitive.Portal>
      </TooltipPrimitive.Root>
    </TooltipPrimitive.Provider>
  )
}