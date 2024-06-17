import {
  Body,
  Container,
  Head,
  Html,
  Text,
  Tailwind,
} from "@react-email/components";
import * as React from "react";
import { emailTailwindConf } from "./config";

interface FeedbackRecoveryEmailProps {
  emailAddress: string;
  message: string;
}

export const FeedbackRecoveryEmail = ({
  emailAddress,
  message
}: FeedbackRecoveryEmailProps) => {
  return (
    <Html>
      <Head/>
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white my-auto mx-auto font-sans px-2">
          <Container className="border border-solid border-[#eaeaea] rounded-lg mt-[40px] mx-auto p-[20px] max-w-[465px]">
            <Text className="font-bold text-[14px] mt-0 mb-1">
              From:
            </Text>
            <Text className="mt-0 mb-5">
               {emailAddress}
            </Text>
            <Text className="font-bold text-[14px] mt-0 mb-1">
              Message:
            </Text>
            <Text className="whitespace-pre-line m-0">
              {message}
            </Text>
          </Container>
        </Body>
      </Tailwind>
    </Html>
  );
};

FeedbackRecoveryEmail.PreviewProps = {
  emailAddress: "dimitri@recallcx.com",
  message: `Hi there,\n\n      I have a             concern.\n\nThanks,\nBob`
} as FeedbackRecoveryEmailProps;

export default FeedbackRecoveryEmail;
