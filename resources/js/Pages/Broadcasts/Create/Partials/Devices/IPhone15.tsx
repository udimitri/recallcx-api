import { Battery50Icon, WifiIcon } from "@heroicons/react/24/solid";
import React from "react";
import clsx from "clsx";

export function IPhone15({
  children,
  headerColor = 'bg-white'
}: {
  children: React.ReactNode
  headerColor?: string,
}) {
  return <>
    <div className={clsx(headerColor, "relative flex mx-auto border-gray-800 dark:border-gray-500 border-[8px] rounded-[2.5rem] h-[600px] w-[300px] shadow-xl")}>
      <div className="inset-x-0 w-full flex items-center justify-between top-2.5 absolute z-10 px-3">
        <div className="text-xs font-medium flex justify-center w-full">12:00</div>
        <div className="w-[100px] h-[20px] bg-gray-800 rounded-[1rem] flex-shrink-0"></div>
        <div className="text-xs font-medium flex justify-end gap-1 w-full">
          <WifiIcon className="w-4 text-black" />
          <Battery50Icon className="w-5 text-black mr-3" />
        </div>
      </div>
      <div className="h-[46px] w-[3px] bg-gray-800 absolute -start-[11px] top-[124px] rounded-s-lg "></div>
      <div className="h-[46px] w-[3px] bg-gray-800 absolute -start-[11px] top-[178px] rounded-s-lg"></div>
      <div className="h-[64px] w-[3px] bg-gray-800 absolute -end-[11px] top-[142px] rounded-e-lg"></div>
      <div className="rounded-[2rem] overflow-hidden w-full  bg-white mt-10">
        {children}
      </div>
    </div>
  </>
}
