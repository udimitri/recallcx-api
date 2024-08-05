import { ChevronLeftIcon } from "@heroicons/react/24/solid";
import { UserIcon } from "@heroicons/react/16/solid";
import {IPhone15} from "@/Pages/Broadcasts/Create/Partials/Devices/IPhone15";
import {Business} from "@/types";

export function TextPreview({
  business,
  message
}: {
  business: Business,
  message: string
}) {
  return <>
    <IPhone15 headerColor="bg-[#fafafb]">
      <div className="mb-4 flex flex-col items-center bg-[#fafafb] pb-1 relative border-b ">
        <ChevronLeftIcon className="w-5 absolute left-1 top-[5px] text-[#248bf5]"/>
        <div className="w-8 h-8 p-0.5 bg-gray-400 rounded-full">
          <UserIcon className="text-white"/>
        </div>
        <span className="mt-1.5 text-[9px] text-black/70">+1 (780) ###-#####</span>
      </div>
      <div className="px-4">
        <p className="text-center text-[10px] font-medium text-[#8e8e93] leading-none mb-0.5">Text Message</p>
        <p className="text-center text-[10px] text-[#8e8e93] mb-2 "><span
          className="font-medium">Today</span> 12:00 PM</p>
        <p className="bg-[#E9E9EB] px-3 py-2 rounded-xl chat text-xs mr-8 whitespace-pre-line">
          {business.name}: {message} Reply STOP to opt-out.
        </p>
      </div>
    </IPhone15>
  </>
}
