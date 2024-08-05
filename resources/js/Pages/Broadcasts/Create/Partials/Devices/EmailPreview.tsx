import { ChevronLeftIcon } from "@heroicons/react/24/solid";
import { EllipsisHorizontalIcon } from "@heroicons/react/16/solid";
import {Business} from "@/types";
import {IPhone15} from "@/Pages/Broadcasts/Create/Partials/Devices/IPhone15";

export function EmailPreview({
  business,
  subject,
  message
}: {
  business: Business,
  subject: string,
  message: string
}) {
  return <>
    <IPhone15>
      <div className="px-3">
        <div className="mb-2 flex justify-between ">
          <ChevronLeftIcon className="w-5 text-[#444444] -ml-1 "/>
          <EllipsisHorizontalIcon className="w-5 text-[#444444] mr-1"/>
        </div>
        <p className="mb-3">{subject}</p>
        <div className="mb-6 flex justify-between">
          <div className="flex ">
            <div className="w-7 h-7 rounded-full bg-orange-400 flex items-center justify-center text-white textsm">
              {business.owner.first_name?.charAt(0).toUpperCase()}
            </div>
            <div className="ml-2 flex flex-col justify-between ">
              <span className="text-[10px]">{business.owner.first_name} from {business.name}</span>
              <span className="text-[10px] text-black/50">to me</span>
            </div>
          </div>
          <EllipsisHorizontalIcon className="w-5 text-[#444444] mr-1"/>
        </div>
        <div className="font-sans px-1">
          <img src={business.logo} className="mb-6 mx-auto w-[60px]"/>

          <p className="mb-8 bg-[#E9E9EB] px-3 py-2 rounded-xl text-xs break-words whitespace-pre-line">
            {message.trim()}
          </p>

          <p className="mb-3 text-center text-[10px] text-[#BBBBBB] leading-none">
            {business.name}<br/>
            {business.address}
          </p>
          <p className="text-center text-[10px] text-[#BBBBBB] leading-none">
            If you would like to stop receiving emails, you can <span className="underline">unsubscribe</span>.
          </p>
        </div>
      </div>
    </IPhone15>
  </>
}
