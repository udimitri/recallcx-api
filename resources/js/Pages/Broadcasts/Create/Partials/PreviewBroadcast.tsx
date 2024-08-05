import { Tab, TabGroup, TabList, TabPanel, TabPanels } from "@headlessui/react";
import clsx from "clsx";
import React from "react";
import {Business} from "@/types";
import {TextPreview} from "@/Pages/Broadcasts/Create/Partials/Devices/TextPreview";
import {EmailPreview} from "@/Pages/Broadcasts/Create/Partials/Devices/EmailPreview";

function Tabs({
  tabs
}: {
  tabs: Array<{
    label: string,
    body: React.ReactNode
  }>
}) {
  return <TabGroup>
    <TabList className="justify-center flex gap-3 py-4 px-4">
      {tabs.map(tab =>
        <Tab
          key={tab.label}
          className={clsx([
            'rounded-full py-1 px-3 text-sm/6 font-semibold focus:outline-none data-[selected]:bg-zinc-300 ',
            'data-[hover]:bg-zinc-200 data-[selected]:data-[hover]:bg-zinc-300',
            'data-[focus]:outline-1 data-[focus]:outline-black'
          ])}>
          {tab.label}
        </Tab>
      )}
    </TabList>
    <TabPanels>
      {tabs.map(tab =>
        <TabPanel
          key={tab.label}
          className="pt-6 pb-12 px-20"
        >
          {tab.body}
        </TabPanel>
      )}
    </TabPanels>
  </TabGroup>
}

export function PreviewBroadcast({
  business,
  subject,
  message
}: {
  business: Business
  subject: string,
  message: string
}) {
  const hasSubjectAndMessage = subject.length && message.length;

  return <div
    className="flex justify-center items-center flex-shrink-0 bg-zinc-100 rounded-2xl h-[736px] w-[460px]"
  >
    {hasSubjectAndMessage ? (
      <Tabs tabs={[
        {label: "SMS", body: <TextPreview business={business} message={message}/>},
        {label: "Email", body: <EmailPreview business={business} subject={subject} message={message}/>}
      ]}/>
    ): (
      <p className="text-black/50 px-16 text-center">
        Enter a subject and message to preview your broadcast.
      </p>
    )}
  </div>;

}
